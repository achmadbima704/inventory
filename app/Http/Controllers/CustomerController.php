<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function index()
    {
        return view('app.data_master.master_customer.index');
    }

    public function getCustomer()
    {
        return DataTables::of(Customer::query())
            ->addColumn('action', function () {
                return '<button class="btn btn-warning edit">Edit</button>';
            })
            ->make();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_customer' => ['required', 'string'],
            'kode_customer' => ['required', 'string'],
            'no_telp_customer' => ['required', 'string'],
            'alamat_customer' => ['required', 'string']
        ]);

        $customer = new Customer($data);

        if ($customer->save()) {
            return ['sukses' => true];
        }

        return ['sukses' => false];
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'nama_customer' => ['required', 'string'],
            'kode_customer' => ['required', 'string'],
            'no_telp_customer' => ['required', 'string'],
            'alamat_customer' => ['required', 'string']
        ]);

        $customer  = Customer::find($request->id);

        $customer->kode_customer = $data['kode_customer'];
        $customer->nama_customer = $data['nama_customer'];
        $customer->no_telp_customer = $data['no_telp_customer'];
        $customer->alamat_customer = $data['alamat_customer'];

        if ($customer->update()) {
            return ['sukses' => true];
        }

        return ['sukses' => false];
    }
}
