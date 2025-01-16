<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PembayranUtangController extends Controller
{
    public function index()
    {
        $supplier = Supplier::orderBy('nama')->get();
        return view('pembayaran_pembelian.index', compact('supplier'));
    }

    public function data()
    {
        $pembelian = Pembelian::orderBy('id_pembelian', 'desc')->get();

        return datatables()
            ->of($pembelian)
            ->addIndexColumn()
            ->addColumn('total_harga', function ($pembelian) {
                return 'Rp.' . format_uang($pembelian->total_harga);
            })
            ->addColumn('bayar', function ($pembelian) {
                return 'Rp.' . format_uang($pembelian->bayar);
            })
            ->addColumn('tanggalbli', function ($pembelian) {
                return tanggal_indonesia($pembelian->tanggal, false);
            })
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
                return '
            <form action="' . route('pembayaran_pembelian.updateStatus', $pembelian->id_pembelian) . '" method="POST" onchange="this.submit()">
            ' . csrf_field() . method_field('PUT') . '
            <select name="status" class="form-control form-control-sm">
                <option value="belum lunas" ' . ($pembelian->status == 'belum lunas' ? 'selected' : '') . '>Belum Lunas</option>
                <option value="lunas" ' . ($pembelian->status == 'lunas' ? 'selected' : '') . '>Lunas</option>
            </select>
            </form>
            ';
            })
            ->addColumn('aksi', function ($pembelian) {
                return '
                <div class="btn-group">
                <button onclick="showDetailpembelian(`' . route('pembelian.show', $pembelian->id_pembelian) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'status'])
            ->make(true);
    }

    public function updateStatus(Request $request, $id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->status = $request->status;
        $pembelian->save();

        return redirect()->route('pembayaran_pembelian.index')->with('success', 'Status berhasil diperbarui');
    }
}
