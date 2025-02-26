<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetil;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanPembayaranPenjualanController extends Controller
{
    public function index(Request $request)
    {

        $tanggalawal = $request->get('tanggalawal', date('Y-m-01'));
        $tanggalakhir = $request->get('tanggalakhir', date('Y-m-d'));
        $status = $request->get('status', '');
        $penjualan = Penjualan::with('konsumen')
            ->whereBetween('created_at', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59']);

        if ($status) {
            $penjualan->where('status', $status);
        }

        $penjualan = $penjualan->orderBy('id_penjualan', 'desc')->get();
        $totalPendapatan = $status ? $penjualan->where('status', $status)->sum('bayar') : $penjualan->sum('bayar');

        return view('laporan_pembayaranpenjualan.index', compact('tanggalawal', 'tanggalakhir', 'totalPendapatan', 'status'));
    }

    public function data(Request $request)
    {
        $tanggalawal = $request->get('tanggalawal', date('Y-m-01'));
        $tanggalakhir = $request->get('tanggalakhir', date('Y-m-d'));
        $status = $request->get('status', '');
        $penjualan = Penjualan::with('konsumen')
            ->whereBetween('created_at', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59']);

        if ($status) {
            $penjualan->where('status', $status);
        }

        $penjualan = $penjualan->orderBy('id_penjualan', 'desc')->get();

        return datatables()
            ->of($penjualan)
            ->addIndexColumn()

            ->addColumn('total_harga', function ($penjualan) {
                return 'Rp.' . format_uang($penjualan->total_harga);
            })
            ->addColumn('bayar', function ($penjualan) {
                return 'Rp.' . format_uang($penjualan->bayar);
            })
            ->addColumn('tanggalbyr', function ($penjualan) {
                return $penjualan->status === 'belum lunas' ? '' : tanggal_indonesia($penjualan->updated_at, false);
            })

            ->addColumn('konsumen', function ($penjualan) {
                return $penjualan->konsumen->nama;
            })
            ->editColumn('diskon', function ($penjualan) {
                return $penjualan->diskon . '%';
            })
            ->addColumn('status', function ($penjualan) {
                return $penjualan->status;
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
                return $detil->barang->kode_barang . '</span>';
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
        $status = $request->get('status', '');

        $penjualan = Penjualan::with(['konsumen', 'detil.barang'])
            ->whereBetween('created_at', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59']);

        if ($request->get('status')) {
            $penjualan->where('status', $request->get('status'));
        }

        $penjualan = $penjualan->orderBy('created_at', 'asc')->get();
        $totalPendapatan = $status ? $penjualan->where('status', $status)->sum('bayar') : $penjualan->sum('bayar');

        foreach ($penjualan as $item) {
            $item->bayar = (float) $item->bayar;
        }

        $pdf = Pdf::loadView('laporan_pembayaranpenjualan.pdf', compact('penjualan', 'tanggalawal', 'tanggalakhir', 'totalPendapatan', 'status'));

        return $pdf->download('laporan_pembayaranpenjualan_' . $tanggalawal . '_to_' . $tanggalakhir . '.pdf');
    }

    public function getTotalPendapatan(Request $request)
    {
        $tanggalawal = $request->get('tanggalawal', date('Y-m-01'));
        $tanggalakhir = $request->get('tanggalakhir', date('Y-m-d'));
        $status = $request->get('status', '');

        $penjualan = Penjualan::whereBetween('tanggal', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59']);

        if ($status) {
            $penjualan->where('status', $status);
        }

        $totalPendapatan = $penjualan->sum('bayar');

        return response()->json(['totalPendapatan' => format_uang($totalPendapatan)]);
    }
}
