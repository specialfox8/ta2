<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianDetil;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanPembayaranPembelianController extends Controller
{
    public function index(Request $request)
    {

        $tanggalawal = $request->get('tanggalawal', date('Y-m-01'));
        $tanggalakhir = $request->get('tanggalakhir', date('Y-m-d'));
        $status = $request->get('status', '');

        $pembelian = Pembelian::with('supplier')
            ->whereBetween('created_at', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59']);
        // ->orderBy('id_pembelian', 'desc')
        // ->get();

        if ($status) {
            $pembelian->where('status', $status);
        }

        $pembelian = $pembelian->orderBy('id_pembelian', 'desc')->get();


        $totalPendapatan = $status ? $pembelian->where('status', $status)->sum('bayar') : $pembelian->sum('bayar');

        // $totalPendapatan = $pembelian->sum('bayar');
        return view('laporan_pembayaranpembelian.index', compact('tanggalawal', 'tanggalakhir', 'totalPendapatan', 'status'));
    }

    public function data(Request $request)
    {

        $tanggalawal = $request->get('tanggalawal', date('Y-m-01'));
        $tanggalakhir = $request->get('tanggalakhir', date('Y-m-d'));
        $status = $request->get('status', '');

        // $pembelian = Pembelian::orderBy('id_pembelian', 'desc')->get();
        $pembelian = Pembelian::with('supplier')
            ->whereBetween('created_at', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59']);
        // ->orderBy('id_pembelian', 'desc')
        // ->get();

        if ($status) {
            $pembelian->where('status', $status);
        }

        $pembelian = $pembelian->orderBy('id_pembelian', 'desc')->get();


        return datatables()
            ->of($pembelian)
            ->addIndexColumn()
            ->addColumn('total_harga', function ($pembelian) {
                return 'Rp.' . format_uang($pembelian->total_harga);
            })
            ->addColumn('bayar', function ($pembelian) {
                return 'Rp.' . format_uang($pembelian->bayar);
            })
            // ->addColumn('tanggalbyr', function ($pembelian) {
            //     return tanggal_indonesia($pembelian->updated_at, false);
            // })
            ->addColumn('tanggalbyr', function ($penjualan) {
                return $penjualan->status === 'belum lunas' ? '' : tanggal_indonesia($penjualan->updated_at, false);
            })
            ->addColumn('supplier', function ($pembelian) {
                return $pembelian->supplier->nama;
            })
            ->editColumn('diskon', function ($pembelian) {
                return $pembelian->diskon . '%';
            })
            ->addColumn('status', function ($pembelian) {
                return $pembelian->status;
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
                return  $detil->barang->kode_barang . '</span>';
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
        $status = $request->get('status', '');

        $pembelian = Pembelian::with(['supplier', 'detil.barang'])
            ->whereBetween('created_at', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59']);
        // ->orderBy('created_at', 'asc')
        // ->get();

        if ($request->get('status')) {
            $pembelian->where('status', $request->get('status'));
        }

        $pembelian = $pembelian->orderBy('created_at', 'asc')->get();

        // $totalPendapatan = $pembelian->sum('bayar');
        $totalPendapatan = $status ? $pembelian->where('status', $status)->sum('bayar') : $pembelian->sum('bayar');

        foreach ($pembelian as $item) {
            $item->bayar = (float) $item->bayar;
        }

        $pdf = Pdf::loadView('laporan_pembayaranpembelian.pdf', compact('pembelian', 'tanggalawal', 'tanggalakhir', 'totalPendapatan', 'status'));

        return $pdf->download('laporan_pembayaranpembelian_' . $tanggalawal . '_to_' . $tanggalakhir . '.pdf');
    }

    public function getTotalPendapatan(Request $request)
    {
        $tanggalawal = $request->get('tanggalawal', date('Y-m-01'));
        $tanggalakhir = $request->get('tanggalakhir', date('Y-m-d'));
        $status = $request->get('status', '');

        $pembelian = Pembelian::whereBetween('tanggal', [$tanggalawal . ' 00:00:00', $tanggalakhir . ' 23:59:59']);

        if ($status) {
            $pembelian->where('status', $status);
        }

        $totalPendapatan = $pembelian->sum('bayar');

        return response()->json(['totalPendapatan' => format_uang($totalPendapatan)]);
    }
}
