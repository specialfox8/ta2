<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetil;
use PDF;
use Illuminate\Http\Request;


class LaporanPenjualanController extends Controller
{
    public function index()
    {

        $tanggalawal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalakhir = date('Y-m-d');
        return view('laporan_penjualan.index', compact('tanggalawal', 'tanggalakhir'));
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
            ->addColumn('konsumen', function ($penjualan) {
                return $penjualan->konsumen->nama;
            })
            ->editColumn('diskon', function ($penjualan) {
                return $penjualan->diskon . '%';
            })
            ->addColumn('aksi', function ($penjualan) {
                return '
                <div class="btn-group">
                <button onclick="showLaporanPenjualan(`' . route('penjualan.show', $penjualan->id_penjualan) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                        </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
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
    public function exportpdf(Request $request)
    {
        // Ambil data penjualan dari database
        $penjualan = Penjualan::orderBy('id_penjualan', 'desc')->get();

        // Render view menjadi PDF, misalnya 'laporan_penjualan.pdf'
        // Pastikan view ini ada di resources/views/laporan_penjualan/pdf.blade.php
        $pdf = PDF::loadView('laporan_penjualan.pdf', compact('penjualan'));

        // Tentukan nama file yang akan di-download dan kembalikan sebagai file PDF
        return $pdf->download('laporan_penjualan_' . date('Ymd') . '.pdf');
    }
}
