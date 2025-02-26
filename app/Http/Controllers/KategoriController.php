<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Kategori;


class KategoriController extends Controller
{
    public function index()
    {
        return view('kategori.index');
    }

    public function data()
    {
        $kategori = Kategori::orderBy('id_kategori', 'desc')->get();

        return datatables()
            ->of($kategori)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                return '
                <div class="btn-group">
                <button onclick="editForm(`' . route('kategori.update', $kategori->id_kategori) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-edit"></i></button>
                <button onclick="deleteData(`' . route('kategori.destroy', $kategori->id_kategori) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $katergori = new Kategori();
        $katergori->nama_kategori = $request->nama_kategori;
        $katergori->save();

        return response()->json('Data Berhasil Disimpan', 200);
    }

    public function show(string $id)
    {
        $kategori = Kategori::find($id);

        return response()->json($kategori);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $katergori = Kategori::find($id);
        $katergori->nama_kategori = $request->nama_kategori;
        $katergori->update();

        return response()->json('Data Berhasil Disimpan', 200);
    }

    public function destroy(string $id)
    {
        $kategori = Kategori::find($id);
        $kategori->delete();
        return response(null, 204);
    }
}
