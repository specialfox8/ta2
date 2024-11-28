<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanPersediaanController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all()->pluck('nama_kategori', 'id_kategori');
        return view('laporan_persediaan.index', compact('kategori'));
    }

    public function data()
    {
        // $barang = Barang::orderBy('id_barang', 'desc')->get();
        $barang = Barang::leftJoin('kategori', 'kategori.id_kategori', 'barang.id_kategori')
            ->select('barang.*', 'nama_kategori')
            // ->orderBy('kode_produk', 'asc')
            ->get();

        return datatables()
            ->of($barang)
            ->addIndexColumn()
            ->addColumn('kode_barang', function ($barang) {
                return  $barang->kode_barang;
            })
            ->addColumn('harga_beli', function ($barang) {
                return 'Rp. ' . format_uang($barang->harga_beli);
            })
            ->addColumn('harga_jual', function ($barang) {
                return 'Rp. ' . format_uang($barang->harga_jual);
            })
            ->addColumn('jumlah', function ($barang) {
                return format_uang($barang->jumlah);
            })
            ->rawColumns(['kode_barang'])
            ->make(true);
    }
    public function exportpdf(Request $request)
    {
        $persediaan = Barang::orderBy('id_barang', 'desc')->get();

        $pdf = Pdf::loadView('laporan_persediaan.pdf', compact('persediaan'));

        return $pdf->download('laporan_persediaan_' . date('Ymd') . '.pdf');
    }
}
