<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Konsumen;
use App\Models\Penjualan;
use App\Models\PenjualanDetil;
use Illuminate\Http\Request;

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
                return tanggal_indonesia($penjualan->created_at, false);
            })
            ->addColumn('konsumen', function ($pembelian) {
                return $pembelian->konsumen->nama;
            })
            // ->addColumn('konsumen', function ($penjualan) {
            //     return $penjualan->konsumen ? $penjualan->konsumen->nama : 'Tidak ada Konsumen';
            // })
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
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $detil = new Penjualan();
        $detil->id_konsumen = $id;
        $detil->total_item = 0;
        $detil->total_harga = 0;
        $detil->diskon = 0;
        $detil->bayar = 0;
        $detil->save();

        session(['id_penjualan' => $detil->id_penjualan]);
        session(['id_konsumen' => $detil->id_konsumen]);

        return redirect()->route('penjualan_detail.index');
    }

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
                return 'Rp.' . format_uang($detil->harga);
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
