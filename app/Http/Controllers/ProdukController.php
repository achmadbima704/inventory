<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProdukController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return view('app.data_master.master_produk.index', compact('kategori'));
    }

    public function getProduk()
    {
        $produk = Produk::with('kategori')->select('produks.*');
        return DataTables::of($produk)
            ->addColumn('status', function($row) {
                return $row->status == 1 ? 'Active' : 'Inactive';
            })
            ->addColumn('action', function() {
                return '<button class="btn btn-warning edit">Edit</button>';
            })
            ->make();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_id' => ['required', 'string'],
            'kode_produk' => ['required', 'string'],
            'nama_produk' => ['required', 'string'],
            'merk' => ['required', 'string'],
            'stok' => ['required', 'integer'],
            'min_stok' => ['required', 'integer'],
            'satuan' => ['required', 'string'],
            'status' => ['required', 'string']
        ]);

        $produk = new Produk($data);

        if ($produk->save()) {
            return ['status' => 1];
        }

        return ['status' => 0];
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'kategori_id' => ['required', 'string'],
            'kode_produk' => ['required', 'string'],
            'nama_produk' => ['required', 'string'],
            'merk' => ['required', 'string'],
            'stok' => ['required', 'integer'],
            'min_stok' => ['required', 'integer'],
            'satuan' => ['required', 'string'],
            'status' => ['required', 'string']
        ]);

        $produk = Produk::find($request->id);

        $produk->kategori_id = $data['kategori_id'];
        $produk->kode_produk = $data['kode_produk'];
        $produk->nama_produk = $data['nama_produk'];
        $produk->merk = $data['merk'];
        $produk->stok = $data['stok'];
        $produk->min_stok = $data['min_stok'];
        $produk->satuan = $data['satuan'];
        $produk->status = $data['status'];

        if ($produk->update()) {
            return ['status' => 1];
        }

        return ['status' => 0];
    }
}
