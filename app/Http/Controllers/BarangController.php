<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::all()->pluck('nama_kategori', 'id_kategori');
        return view('barang.index', compact('kategori'));
    }

    public function data()
    {
        // $barang = Barang::orderBy('id_barang', 'desc')->get();
        $barang = Barang::leftJoin('kategori', 'kategori.id_kategori', 'barang.id_kategori')
            ->select('barang.*', 'nama_kategori')
            // ->orderBy('kode_produk', 'asc')
            ->get();

        return datatables()
            ->of($barang)
            ->addIndexColumn()
            ->addColumn('kode_barang', function ($barang) {
                return '<span class="label label-success">' . $barang->kode_barang . '</span>';
            })
            ->addColumn('harga_beli', function ($barang) {
                return 'Rp. ' . format_uang($barang->harga_beli);
            })
            ->addColumn('harga_jual', function ($barang) {
                return 'Rp. ' . format_uang($barang->harga_jual);
            })
            ->addColumn('jumlah', function ($barang) {
                return format_uang($barang->jumlah);
            })
            ->addColumn('aksi', function ($barang) {
                return '
                <div class="btn-group">
                <button onclick="editForm(`' . route('barang.update', $barang->id_barang) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-edit"></i></button>
                <button onclick="deleteData(`' . route('barang.destroy', $barang->id_barang) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'kode_barang'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $barangTerakhir = Barang::latest('id_barang')->first();

        $idBarangBaru = ($barangTerakhir ? $barangTerakhir->id_barang : 0) + 1;

        $request['kode_barang'] = str_pad($idBarangBaru, 4, '0', STR_PAD_LEFT);

        $barang = Barang::create($request->all());

        return response()->json('Data Berhasil Disimpan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $barang = Barang::find($id);

        return response()->json($barang);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $barang = Barang::find($id);

        $barang->update($request->all());

        return response()->json('Data Berhasil Disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang = Barang::find($id);
        $barang->delete();
        return response(null, 204);
    }
}
