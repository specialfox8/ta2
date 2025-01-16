<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianDetil;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;

class LaporanPembelianController extends Controller
{
    public function index(Request $request)
    {

        $tanggalawal = $request->get('tanggalawal', date('Y-m-01'));
        $tanggalakhir = $request->get('tanggalakhir', date('Y-m-d'));

        $pembelian = Pembelian::with('supplier')
            ->whereBetween('tanggal', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59'])
            ->orderBy('id_pembelian', 'desc')
            ->get();

        $totalPendapatan = $pembelian->sum('bayar');
        if ($request->ajax()) {
            return response()->json(['totalPendapatan' => $totalPendapatan]);
        }

        return view('laporan_pembelian.index', compact('tanggalawal', 'tanggalakhir', 'totalPendapatan'));
    }

    public function data(Request $request)
    {
        $tanggalawal = $request->get('tanggalawal', date('Y-m-01'));
        $tanggalakhir = $request->get('tanggalakhir', date('Y-m-d'));
        $pembelian = Pembelian::with('supplier')
            ->whereBetween('tanggal', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59'])
            ->orderBy('id_pembelian', 'desc')
            ->get();

        return datatables()
            ->of($pembelian)
            ->addIndexColumn()
            ->addColumn('total_item', function ($pembelian) {
                return format_uang($pembelian->total_item);
            })
            ->addColumn('total_harga', function ($pembelian) {
                return 'Rp.' . format_uang($pembelian->total_harga);
            })
            ->addColumn('bayar', function ($pembelian) {
                return 'Rp.' . format_uang($pembelian->bayar);
            })
            ->addColumn('tanggal', function ($pembelian) {
                return tanggal_indonesia($pembelian->tanggal, false);
            })
            ->addColumn('supplier', function ($pembelian) {
                return $pembelian->supplier->nama;
            })
            ->editColumn('diskon', function ($pembelian) {
                return $pembelian->diskon . '%';
            })
            ->addColumn('aksi', function ($pembelian) {
                return '
                <div class="btn-group">
                <button onclick="showLaporanPembelian(`' . route('pembelian.show', $pembelian->id_pembelian) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                        </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show($id)
    {
        $detil = PembelianDetil::with('barang')
            ->where('id_pembelian', $id)
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
                return 'Rp.' . format_uang($detil->harga_beli);
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

        $pembelian = Pembelian::with(['supplier', 'detil.barang'])
            ->whereBetween('tanggal', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59'])
            ->orderBy('tanggal', 'asc')
            ->get();

        $totalPendapatan = $pembelian->sum('bayar');

        foreach ($pembelian as $item) {
            $item->bayar = (float) $item->bayar;
        }

        $pdf = FacadePdf::loadView('laporan_pembelian.pdf', compact('pembelian', 'tanggalawal', 'tanggalakhir', 'totalPendapatan'));

        return $pdf->download('laporan_pembelian_' . $tanggalawal . '_to_' . $tanggalakhir . '.pdf');
    }

    public function getTotalPendapatan(Request $request)
    {
        $tanggalawal = $request->get('tanggalawal', date('Y-m-01'));
        $tanggalakhir = $request->get('tanggalakhir', date('Y-m-d'));

        $pembelian = Pembelian::whereBetween('tanggal', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59']);

        $totalPendapatan = $pembelian->sum('bayar');

        return response()->json(['totalPendapatan' => format_uang($totalPendapatan)]);
    }
}
