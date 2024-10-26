<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran_utang;
use Illuminate\Http\Request;

class PembayaranUtangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pembayaran_utang.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function data()
    {
        $pembayaran_utang = Pembayaran_utang::orderBy('id_pembayaran_utang', 'desc')->get();

        return datatables()
            ->of($pembayaran_utang)
            ->addIndexColumn()
            ->addColumn('aksi', function ($pembayaran_utang) {
                return '
                <div class="btn-group">
                <button onclick="editForm(`' . route('pembayaran_utang.update', $pembayaran_utang->id_pembayaran_utang) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-edit"></i></button>
                <button onclick="deleteData(`' . route('pembayaran_utang.destroy', $pembayaran_utang->id_pembayaran_utang) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $katergori = new pembayaran_utang();
        $katergori->nama_pembayaran_utang = $request->nama_pembayaran_utang;
        $katergori->save();

        return response()->json('Data Berhasil Disimpan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pembayaran_utang = pembayaran_utang::find($id);

        return response()->json($pembayaran_utang);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembayaran_utang $pembayaran_utang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $katergori = pembayaran_utang::find($id);
        $katergori->nama_pembayaran_utang = $request->nama_pembayaran_utang;
        $katergori->update();

        return response()->json('Data Berhasil Disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pembayaran_utang = pembayaran_utang::find($id);
        $pembayaran_utang->delete();
        return response(null, 204);
    }
}
