<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function index()
    {
        return view('app.data_master.master_supplier.index');
    }

    public function getSupplier()
    {
        return DataTables::of(Supplier::query())
            ->addColumn('action', function () {
                return '<button class="btn btn-warning edit">Edit</button>';
            })
            ->make();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_supplier' => ['required', 'string'],
            'kode_supplier' => ['required', 'string'],
            'no_telp_supplier' => ['required', 'string'],
            'alamat_supplier' => ['required', 'string']
        ]);

        $supplier = new Supplier($data);

        if ($supplier->save()) {
            return ['sukses' => true];
        }

        return ['sukses' => false];
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'nama_supplier' => ['required', 'string'],
            'kode_supplier' => ['required', 'string'],
            'no_telp_supplier' => ['required', 'string'],
            'alamat_supplier' => ['required', 'string']
        ]);

        $supplier  = Supplier::find($request->id);

        $supplier->kode_supplier = $data['kode_supplier'];
        $supplier->nama_supplier = $data['nama_supplier'];
        $supplier->no_telp_supplier = $data['no_telp_supplier'];
        $supplier->alamat_supplier = $data['alamat_supplier'];

        if ($supplier->update()) {
            return ['sukses' => true];
        }

        return ['sukses' => false];
    }
}
