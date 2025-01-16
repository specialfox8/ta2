<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LaporanPersediaanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalawal = $request->get('tanggalawal', date('Y-m-01'));
        $tanggalakhir = $request->get('tanggalakhir', date('Y-m-d'));

        return $this->data($request);
    }

    public function data(Request $request)
    {
        $tanggalawal = $request->input('tanggalawal', date('Y-m-01'));
        $tanggalakhir = $request->input('tanggalakhir', date('Y-m-d'));


        $pembelian = Pembelian::select('tanggal', DB::raw('SUM(bayar) as total_beli'))
            ->whereBetween('tanggal', [$tanggalawal, $tanggalakhir])
            ->groupBy('tanggal')
            ->get();

        $penjualan = Penjualan::select('tanggal', DB::raw('SUM(bayar) as total_jual'))
            ->whereBetween('tanggal', [$tanggalawal, $tanggalakhir])
            ->groupBy('tanggal')
            ->get();

        $data = [];
        $totalPendapatan = 0;

        foreach ($pembelian as $item) {
            $penjualanPadaTanggal = $penjualan->firstWhere('tanggal', $item->tanggal);
            $totalPenjualan = $penjualanPadaTanggal ? $penjualanPadaTanggal->total_jual : 0;

            $pendapatan = $totalPenjualan - $item->total_beli;
            $totalPendapatan += $pendapatan;

            $data[] = [
                'pembelian' => format_uang($item->total_beli),
                'penjualan' => format_uang($totalPenjualan),
                'tanggalbli' => tanggal_indonesia($item->tanggal, false),
                'tanggaljl' => tanggal_indonesia($item->tanggal, false),
                'pendapatan' => format_uang($pendapatan),
            ];
        }

        return view('laporan_persediaan.index', compact('data', 'totalPendapatan', 'tanggalawal', 'tanggalakhir'));
    }


    public function exportpdf(Request $request)
    {
        $tanggalawal = $request->input('tanggalawal', date('Y-m-01'));
        $tanggalakhir = $request->input('tanggalakhir', date('Y-m-d'));

        // Ambil data pembelian dan penjualan untuk rentang tanggal
        $pembelian = Pembelian::select('tanggal', DB::raw('SUM(bayar) as total_beli'))
            ->whereBetween('tanggal', [$tanggalawal, $tanggalakhir])
            ->groupBy('tanggal')
            ->get();

        $penjualan = Penjualan::select('tanggal', DB::raw('SUM(bayar) as total_jual'))
            ->whereBetween('tanggal', [$tanggalawal, $tanggalakhir])
            ->groupBy('tanggal')
            ->get();

        $data = [];
        $totalPendapatan = 0;

        foreach ($pembelian as $item) {
            $penjualanPadaTanggal = $penjualan->firstWhere('tanggal', $item->tanggal);
            $totalPenjualan = $penjualanPadaTanggal ? $penjualanPadaTanggal->total_jual : 0;

            $pendapatan = $totalPenjualan - $item->total_beli;
            $totalPendapatan += $pendapatan;

            $data[] = [
                'pembelian' => $item->total_beli,
                'penjualan' => $totalPenjualan,
                'tanggalbli' => $item->tanggal,
                'tanggaljl' => $item->tanggal,
                'pendapatan' => $pendapatan,
            ];
        }

        $pdf = Pdf::loadView('laporan_persediaan.pdf', compact('data', 'totalPendapatan', 'tanggalawal', 'tanggalakhir'));
        return $pdf->download('laporan_pendapatan.pdf');
    }
}
