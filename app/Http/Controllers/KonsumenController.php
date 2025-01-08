<?php

namespace App\Http\Controllers;

use App\Models\Konsumen;
use Illuminate\Http\Request;

class KonsumenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \illuminate\Http\Response
     */
    public function index()
    {

        return view('konsumen.index');
    }

    public function data()
    {
        $konsumen = Konsumen::orderBy('id_konsumen', 'desc')->get();

        return datatables()
            ->of($konsumen)
            ->addIndexColumn()
            ->addColumn('aksi', function ($konsumen) {
                return '
                <div class="btn-group">
                <button onclick="editForm(`' . route('konsumen.update', $konsumen->id_konsumen) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-edit"></i></button>
                <button onclick="deleteData(`' . route('konsumen.destroy', $konsumen->id_konsumen) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $konsumen = Konsumen::create($request->all());

        // return response()->json('Data Berhasil Disimpan', 200);

        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'required|string|regex:/^\d{10,15}$/',
        ]);

        Konsumen::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
        ]);

        return response()->json('Data Berhasil Disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \illuminate\Http\Response
     */
    public function show($id)
    {
        $konsumen = konsumen::find($id);

        return response()->json($konsumen);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \illuminate\Http\Response
     */
    public function edit(Konsumen $konsumen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     *  @param int $id
     * @return \illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $konsumen = konsumen::find($id)->update($request->all());

        return response()->json('Data Berhasil Disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \illuminate\Http\Response
     */
    public function destroy($id)
    {
        $konsumen = konsumen::find($id);
        $konsumen->delete();
        return response(null, 204);
    }
}
