<?php

namespace App\Http\Controllers;

use App\Models\Konsumen;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class PembayaranPiutangController extends Controller
{
    public function index()
    {
        $konsumen = Konsumen::orderBy('nama')->get();
        return view('pembayaran_penjualan.index', compact('konsumen'));
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
            // ->addColumn('konsumen', function ($penjualan) {
            //     return $penjualan->konsumen ? $penjualan->konsumen->nama : 'Tidak ada Konsumen';
            // })
            ->editColumn('diskon', function ($penjualan) {
                return $penjualan->diskon . '%';
            })
            ->addColumn('status', function ($penjualan) {
                return '
            <form action="' . route('pembayaran_penjualan.updateStatus', $penjualan->id_penjualan) . '" method="POST" onchange="this.submit()">
            ' . csrf_field() . method_field('PUT') . '
            <select name="status" class="form-control form-control-sm">
                <option value="belum lunas" ' . ($penjualan->status == 'belum lunas' ? 'selected' : '') . '>Belum Lunas</option>
                <option value="lunas" ' . ($penjualan->status == 'lunas' ? 'selected' : '') . '>Lunas</option>
            </select>
            </form>
            ';
            })
            ->addColumn('aksi', function ($penjualan) {
                return '
                <div class="btn-group">
                <button onclick="editPenjualan(`' . route('penjualan.show', $penjualan->id_penjualan) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                <button onclick="showDetailPenjualan(`' . route('penjualan.show', $penjualan->id_penjualan) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'status'])
            ->make(true);
    }

    public function updateStatus(Request $request, $id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $penjualan->status = $request->status;
        $penjualan->save();

        return redirect()->route('pembayaran_penjualan.index')->with('success', 'Status berhasil diperbarui');
    }
}
