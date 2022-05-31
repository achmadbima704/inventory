<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Customer;
use App\Models\DetailBarangKeluar;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        if (count($produk) == 0) {
            return redirect()
                ->route('app.view.dataproduk')
                ->with('error', 'Data produk masuh kosong, silahkan buat produk terlebih dahulu.');
        }
        $customer = Customer::all();
        return view('app.transaksi.barang_keluar.index', [
            'produk' => $produk,
            'customer' => $customer
        ]);
    }

    public function store(Request $request)
    {
        $item = [];

        DB::transaction(function () use ($request, $item) {
            $barangMasuk = new BarangKeluar([
                'kode_transaksi' => $request['kode_transaksi'],
                'tgl_transaksi' => $request['tgl_transaksi'],
                'user_id' => auth()->user()->id,
                'customer_id' => $request['customer_id'],
                'pengirim' => $request['pengirim']
            ]);
            $barangMasuk->save();

            foreach ($request['produk_id'] as $key => $value) {
                array_push($item, [
                    'barang_keluar_id' => $barangMasuk->id,
                    'produk_id' => $value,
                    'qty' => $request['qty'][$key]
                ]);
            }

            foreach ($item as $key => $value) {
                $detail = DetailBarangKeluar::create([
                    'barang_keluar_id' => $barangMasuk->id,
                    'produk_id' => $item[$key]['produk_id'],
                    'qty' => $item[$key]['qty'],

                ]);

                $produk  = Produk::find($item[$key]['produk_id']);
                $produk->stok -= ($item[$key]['qty']);
                $produk->update();
            }
        });

        return redirect()->back()->with('success', 'Data berhasil di simpan.');
    }

    public function cetak($id)
    {
        $data = DB::table('barang_keluars')
            ->select([
                'barang_keluars.id',
                'kode_transaksi',
                'tgl_transaksi',
                'user_id',
                'customer_id',
                'pengirim',
                'customers.nama_customer',
                'users.name'
            ])
            ->leftJoin('users', 'users.id', '=', 'barang_keluars.user_id')
            ->leftJoin('customers', 'customers.id', '=', 'barang_keluars.customer_id')
            ->where(['barang_keluars.id' => $id])
            ->first();

        $detail = DB::table('detail_barang_keluars')
                ->select([
                    'produk_id',
                    'qty',
                    'produks.nama_produk'
                ])
                ->leftJoin('produks', 'produks.id', '=', 'detail_barang_keluars.produk_id')
                ->where(['barang_keluar_id' => $data->id])
                ->get();

        return view('app.transaksi.barang_keluar.cetak', ['data' => $data, 'detail' => $detail]);
    }
}
