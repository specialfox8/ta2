<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\PembelianDetil;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supplier = Supplier::orderBy('nama')->get();
        return view('pembelian.index', compact('supplier'));
    }

    public function data()
    {
        $detil = Pembelian::orderBy('id_pembelian', 'desc')->get();

        return datatables()
            ->of($detil)
            ->addIndexColumn()
            ->addColumn('total_item', function ($detil) {
                return format_uang($detil->total_item);
            })
            ->addColumn('nama_barang', function ($detil) {
                return 'Rp.' . format_uang($detil->nama_barang);
            })
            ->addColumn('bayar', function ($detil) {
                return 'Rp.' . format_uang($detil->bayar);
            })
            ->addColumn('tanggal', function ($detil) {
                return tanggal_indonesia($detil->created_at, false);
            })
            ->addColumn('supplier', function ($detil) {
                return $detil->supplier->nama;
            })
            ->addColumn('aksi', function ($detil) {
                return '
                <div class="btn-group">
                <button onclick="showDetail(`' . route('pembelian.show', $detil->id_pembelian) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                <button onclick="deleteData(`' . route('pembelian.destroy', $detil->id_pembelian) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
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
        $detil = new Pembelian();
        $detil->id_supplier = $id;
        $detil->total_item = 0;
        $detil->nama_barang = 0;
        $detil->diskon = 0;
        $detil->bayar = 0;
        $detil->save();

        session(['id_pembelian' => $detil->id_pembelian]);
        session(['id_supplier' => $detil->id_supplier]);

        return redirect()->route('pembelian_detail.index');
    }

    public function store(Request $request)
    {
        $detil = Pembelian::find($request->id_pembelian);
        $detil->total_item = $request->total_item;
        $detil->nama_barang = $request->total;
        $detil->diskon = $request->diskon;
        $detil->bayar = $request->bayar;
        $detil->update();

        $detil = PembelianDetil::where('id_pembelian', $detil->id_pembelian)->get();

        foreach ($detil as $item) {
            $barang = Barang::find($item->id_barang);
            $barang->jumlah += $item->jumlah;
            $barang->update();
        }

        return redirect()->route('pembelian.index');
    }

    public function show($id)
    {
        $detil = PembelianDetil::with('barang')->where('id_pembelian', $id)->get();

        return datatables()
            ->of($detil)
            ->addIndexColumn()
            ->addColumn('kode_barang', function ($detil) {
                return '<span class="label label-success">' . $detil->barang->kode_barang . '</span>';
            })
            ->addColumn('nama_barang', function ($detil) {
                return $detil->nama_barang;
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
        $pembelian = Pembelian::find($id);
        $detil = PembelianDetil::where('id_pembelian', $pembelian->id_pembelian)->get();
        foreach ($detil as $item) {
            $item->delete();
        }

        $pembelian->delete();

        return response(null, 204);
    }
}
