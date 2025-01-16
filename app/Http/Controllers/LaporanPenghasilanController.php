<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Penjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LaporanPenghasilanController extends Controller
{
    // Fungsi untuk menampilkan laporan penghasilan
    public function index(Request $request)
    {
        $tanggalawal = $request->get('tanggalawal', date('Y-m-01'));
        $tanggalakhir = $request->get('tanggalakhir', date('Y-m-d'));

        $pembelian = Pembelian::with('supplier')
            ->whereBetween('tanggal', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59'])
            ->orderBy('id_pembelian', 'desc')
            ->get();

        $penjualan = Penjualan::with('konsumen')
            ->whereBetween('tanggal', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59'])
            ->orderBy('id_penjualan', 'desc')
            ->get();

        $totalpembelian = $pembelian->sum('bayar');
        $totalpenjualan = $penjualan->sum('bayar');
        $totalPendapatan = $totalpenjualan - $totalpembelian;

        if ($request->ajax()) {
            return response()->json(['totalPendapatan' => $totalPendapatan]);
        }

        return view('laporan_penghasilan.index', compact('tanggalawal', 'tanggalakhir', 'totalPendapatan'));
    }

    public function data(Request $request)
    {
        $tanggalawal = $request->get('tanggalawal', date('Y-m-01'));
        $tanggalakhir = $request->get('tanggalakhir', date('Y-m-d'));

        // Ambil data Pembelian dan Penjualan dalam rentang tanggal
        $pembelian = Pembelian::with('supplier')
            ->whereBetween('tanggal', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59'])
            ->orderBy('tanggal')
            ->get();

        $penjualan = Penjualan::with('konsumen')
            ->whereBetween('tanggal', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59'])
            ->orderBy('tanggal')
            ->get();

        // $data = [];
        $totalpembelian = $pembelian->sum('bayar');
        $totalpenjualan = $penjualan->sum('bayar');
        $totalPendapatan = $totalpenjualan - $totalpembelian;

        $data = [];
        foreach ($pembelian as $item) {
            $penjualanPadaTanggal = $penjualan->firstWhere('tanggal', $item->tanggal);
            $totalPenjualan = $penjualanPadaTanggal ? $penjualanPadaTanggal->bayar : 0;
            $pendapatan = $totalPenjualan - $item->bayar;
        }
        $data[] = [

            'pembelian' => 'Rp. ' . format_uang($pembelian->sum('bayar')),
            'penjualan' => 'Rp. ' . format_uang($penjualan->sum('bayar')),
            'pendapatan' => 'Rp. ' . format_uang($totalPendapatan),
        ];

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }


    // Fungsi untuk meng-export laporan ke PDF
    public function exportpdf(Request $request)
    {
        $tanggalawal = $request->get('tanggalawal', date('Y-m-01'));
        $tanggalakhir = $request->get('tanggalakhir', date('Y-m-d'));

        $pembelian = Pembelian::with('supplier')
            ->whereBetween('tanggal', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59'])
            ->orderBy('id_pembelian', 'desc')
            ->get();

        $penjualan = Penjualan::with('konsumen')
            ->whereBetween('tanggal', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59'])
            ->orderBy('id_penjualan', 'desc')
            ->get();

        $data = [];
        foreach ($pembelian as $item) {
            $penjualanPadaTanggal = $penjualan->firstWhere('tanggal', $item->tanggal);
            $totalPenjualan = $penjualanPadaTanggal ? $penjualanPadaTanggal->bayar : 0;
            $pendapatan = $totalPenjualan - $item->bayar;

            $data[] = [
                'pembelian' => 'Rp.' . format_uang($item->bayar),
                'penjualan' => 'Rp.' . format_uang($totalPenjualan),
                'pendapatan' => 'Rp.' . format_uang($pendapatan),
            ];
        }

        // Menggunakan DomPDF untuk menghasilkan PDF
        $pdf = Pdf::loadView('laporan_penghasilan.pdf', compact('tanggalawal', 'tanggalakhir', 'data'));

        // Mengunduh file PDF
        return $pdf->download('laporan_penghasilan_' . date('Y-m-d') . '.pdf');
    }
}
