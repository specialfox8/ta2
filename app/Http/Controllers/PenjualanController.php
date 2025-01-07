<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Konsumen;
use App\Models\Penjualan;
use App\Models\PenjualanDetil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PenjualanController extends Controller
{
    public function index()
    {
        $konsumen = Konsumen::orderBy('nama')->get();
        return view('penjualan.index', compact('konsumen'));
    }

    public function data()
    {
        $penjualan = Penjualan::orderBy('id_penjualan', 'desc')->get();

        return datatables()
            ->of($penjualan)
            ->addIndexColumn()
            ->addColumn('total_item', function ($penjualan) {
                return format_uang($penjualan->total_item);
            })
            ->addColumn('total_harga', function ($penjualan) {
                return 'Rp.' . format_uang($penjualan->total_harga);
            })
            ->addColumn('bayar', function ($penjualan) {
                return 'Rp.' . format_uang($penjualan->bayar);
            })
            ->addColumn('tanggal', function ($penjualan) {
                return tanggal_indonesia($penjualan->tanggal, false);
            })
            ->addColumn('konsumen', function ($penjualan) {
                return $penjualan->konsumen->nama;
            })
            ->editColumn('diskon', function ($penjualan) {
                return $penjualan->diskon . '%';
            })
            ->addColumn('aksi', function ($penjualan) {
                return '
                <div class="btn-group">
                <button onclick="showDetailPenjualan(`' . route('penjualan.show', $penjualan->id_penjualan) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                <button onclick="deleteData(`' . route('penjualan.destroy', $penjualan->id_penjualan) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi',])
            ->make(true);
    }


    public function createWithDate(Request $request)
    {
        Log::info('createWithDate method called', $request->all());
        $validated = $request->validate([
            'id_konsumen' => 'required|exists:konsumen,id_konsumen',
            'tanggal' => 'required|date',
        ]);

        $tahun = date('y', strtotime($validated['tanggal']));
        $bulan = date('m', strtotime($validated['tanggal']));
        $hari = date('d', strtotime($validated['tanggal']));

        $lastKode = Penjualan::whereDate('tanggal', $validated['tanggal'])
            ->orderBy('id_penjualan', 'desc')
            ->first();

        $urut = $lastKode ? intval(substr($lastKode->kode_penjualan, -3)) + 1 : 1;
        $kode_penjualan = $tahun . $bulan . $hari . str_pad($urut, 3, '0', STR_PAD_LEFT);

        $detil = new Penjualan();
        $detil->id_konsumen = $validated['id_konsumen'];
        $detil->kode_penjualan = $kode_penjualan;
        $detil->total_item = 0;
        $detil->total_harga = 0;
        $detil->diskon = 0;
        $detil->bayar = 0;
        $detil->tanggal = $validated['tanggal'];
        $detil->save();

        session(['id_penjualan' => $detil->id_penjualan]);
        session(['id_konsumen' => $detil->id_konsumen]);

        return redirect()->route('penjualan_detail.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create($id)
    // {
    //     $tahun = date('y');
    //     $bulan = date('m');
    //     $hari = date('d');

    //     $lastKode = Penjualan::whereYear('created_at', date('Y'))
    //         ->whereMonth('created_at', date('m'))
    //         ->orderBy('id_penjualan', 'desc')
    //         ->first();

    //     $lastDate = $lastKode ? $lastKode->created_at->format('d') : null;
    //     // $urut = $lastKode ? intval(substr($lastKode->kode_penjualan, -3)) + 1 : 1;
    //     $urut = ($lastDate != $hari) ? 1 : (intval(substr($lastKode->kode_penjualan, -3)) + 1);
    //     $kode_penjualan = $tahun . $bulan . $hari . str_pad($urut, 3, '0', STR_PAD_LEFT);

    //     $detil = new Penjualan();
    //     $detil->id_konsumen = $id;
    //     $detil->kode_penjualan = $kode_penjualan;
    //     $detil->total_item = 0;
    //     $detil->total_harga = 0;
    //     $detil->diskon = 0;
    //     $detil->bayar = 0;
    //     $detil->save();

    //     session(['id_penjualan' => $detil->id_penjualan]);
    //     session(['id_konsumen' => $detil->id_konsumen]);

    //     return redirect()->route('penjualan_detail.index');
    // }

    public function store(Request $request)
    {
        $penjualan = Penjualan::find($request->id_penjualan);
        $penjualan->total_item = $request->total_item;
        $penjualan->total_harga = $request->total;
        $penjualan->diskon = $request->diskon;
        $penjualan->bayar = $request->bayar;
        $penjualan->update();

        $detil = PenjualanDetil::where('id_penjualan', $penjualan->id_penjualan)->get();

        foreach ($detil as $item) {
            $barang = Barang::find($item->id_barang);
            $barang->jumlah -= $item->jumlah;
            $barang->update();
        }

        return redirect()->route('penjualan.index');
    }

    public function show($id)
    {
        $detil = PenjualanDetil::with('barang')
            ->where('id_penjualan', $id)
            ->get();

        return datatables()
            ->of($detil)
            ->addIndexColumn()
            ->addColumn('kode_barang', function ($detil) {
                return '<span class="label label-success">' . $detil->barang->kode_barang . '</span>';
            })
            ->addColumn('nama_barang', function ($detil) {
                return $detil->barang->nama_barang;
            })
            ->addColumn('harga', function ($detil) {
                return 'Rp.' . format_uang($detil->harga_jual);
            })
            ->addColumn('jumlah', function ($detil) {
                return  format_uang($detil->jumlah);
            })
            ->addColumn('subtotal', function ($detil) {
                return  format_uang($detil->subtotal);
            })
            ->addColumn('tanggal', function ($detil) {
                return tanggal_indonesia($detil->created_at, false);
            })
            ->rawColumns(['kode_barang'])
            ->make(true);
    }

    public function updateStatus(Request $request, $id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $penjualan->status = $request->status;
        $penjualan->save();

        return redirect()->route('pembayaran_penjualan.index')->with('success', 'Status berhasil diperbarui');
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::find($id);
        $detil = PenjualanDetil::where('id_penjualan', $penjualan->id_penjualan)->get();
        foreach ($detil as $item) {
            $item->delete();
        }

        $penjualan->delete();

        return response(null, 204);
    }
}
