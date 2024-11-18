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
        $pembelian = Pembelian::orderBy('id_penjualan', 'desc')->get();

        return datatables()
            ->of($pembelian)
            ->addIndexColumn()
            // ->addColumn('total_item', function ($pembelian) {
            //     return format_uang($pembelian->total_item);
            // })
            ->addColumn('total_harga', function ($pembelian) {
                return 'Rp.' . format_uang($pembelian->total_harga);
            })
            ->addColumn('bayar', function ($pembelian) {
                return 'Rp.' . format_uang($pembelian->bayar);
            })
            ->addColumn('tanggal', function ($pembelian) {
                return tanggal_indonesia($pembelian->created_at, false);
            })
            ->addColumn('supplier', function ($pembelian) {
                return $pembelian->supplier->nama;
            })
            // ->addColumn('supplier', function ($pembelian) {
            //     return $pembelian->supplier ? $pembelian->supplier->nama : 'Tidak ada supplier';
            // })
            ->editColumn('diskon', function ($pembelian) {
                return $pembelian->diskon . '%';
            })
            ->addColumn('status', function ($pembelian) {
                return '
            <form action="' . route('pembayaran_penjualan.updateStatus', $pembelian->id_penjualan) . '" method="POST" onchange="this.submit()">
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
                <button onclick="editPenjualan(`' . route('pembelian.show', $pembelian->id_penjualan) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                <button onclick="showDetailPenjualan(`' . route('pembelian.show', $pembelian->id_penjualan) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
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

        return redirect()->route('pembayaran_penjualan.index')->with('success', 'Status berhasil diperbarui');
    }
}
