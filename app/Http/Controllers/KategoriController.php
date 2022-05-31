<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KategoriController extends Controller
{
    public function index()
    {
        return view('app.data_master.master_kategori.index');
    }

    public function getKategori(Request $request)
    {
        return Datatables::of(Kategori::query())
            ->addColumn('action', function () {
                return '<button class="btn btn-warning edit">Edit</button>';
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_kategori' => ['required', 'string'],
            'nama_kategori' => ['required', 'string']
        ]);

        $kategori = new Kategori($data);

        if ($kategori->save()) {
            return [
                'sukses' => true
            ];
        }

        return ['sukses' => false];
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'kode_kategori' => ['required', 'string'],
            'nama_kategori' => ['required', 'string']
        ]);

        $kategori = Kategori::find($request->id);

        $kategori->kode_kategori = $data['kode_kategori'];
        $kategori->nama_kategori = $data['nama_kategori'];

        if ($kategori->update()) {
            return ['sukses' => true];
        }

        return ['sukses' => false];
    }
}
