<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetil;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use PDF;
use Illuminate\Http\Request;


class LaporanPenjualanController extends Controller
{
    public function index(Request $request)
    {

        $tanggalawal = $request->get('tanggalawal', date('Y-m-01'));
        $tanggalakhir = $request->get('tanggalakhir', date('Y-m-d'));

        $penjualan = Penjualan::with('konsumen')
            ->whereBetween('tanggal', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59'])
            ->orderBy('id_penjualan', 'desc')
            ->get();

        $totalPendapatan = $penjualan->sum('bayar');
        if ($request->ajax()) {
            return response()->json(['totalPendapatan' => $totalPendapatan]);
        }


        return view('laporan_penjualan.index', compact('tanggalawal', 'tanggalakhir', 'totalPendapatan'));
    }

    public function data(Request $request)
    {
        $tanggalawal = $request->get('tanggalawal', date('Y-m-01'));
        $tanggalakhir = $request->get('tanggalakhir', date('Y-m-d'));

        // $penjualan = Penjualan::orderBy('id_penjualan', 'desc')->get();
        $penjualan = Penjualan::with('konsumen')
            ->whereBetween('tanggal', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59'])
            ->orderBy('id_penjualan', 'desc')
            ->get();

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
    public function exportpdf(Request $request)
    {
        $tanggalawal = $request->get('tanggalawal', date('Y-m-01'));
        $tanggalakhir = $request->get('tanggalakhir', date('Y-m-d'));

        $penjualan = Penjualan::with(['konsumen', 'detil.barang'])
            ->whereBetween('tanggal', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59'])
            ->orderBy('tanggal', 'asc')
            ->get();

        $totalPendapatan = $penjualan->sum('bayar');

        foreach ($penjualan as $item) {
            $item->bayar = (float) $item->bayar;
        }

        $pdf = FacadePdf::loadView('laporan_penjualan.pdf', compact('penjualan', 'tanggalawal', 'tanggalakhir', 'totalPendapatan'));

        return $pdf->download('laporan_penjualan_' . $tanggalawal . '_to_' . $tanggalakhir . '.pdf');
    }

    public function getTotalPendapatan(Request $request)
    {
        $tanggalawal = $request->get('tanggalawal', date('Y-m-01'));
        $tanggalakhir = $request->get('tanggalakhir', date('Y-m-d'));

        $pembelian = Penjualan::whereBetween('tanggal', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59']);

        $totalPendapatan = $pembelian->sum('bayar');

        return response()->json(['totalPendapatan' => format_uang($totalPendapatan)]);
    }
}
