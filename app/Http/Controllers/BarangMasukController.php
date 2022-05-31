<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\DetailBarangMasuk;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        if (count($produk) == 0) {
            return redirect()->route('app.view.dataproduk')->with('error', 'Data produk masuh kosong, silahkan buat produk terlebih dahulu.');
        }
        $supplier = Supplier::all();
        return view('app.transaksi.barang_masuk.index', [
            'produk' => $produk,
            'supplier' => $supplier
        ]);
    }

    public function store(Request $request)
    {
        $item = [];

        $id = DB::transaction(function () use ($request, $item) {
            $barangMasuk = new BarangMasuk([
                'kode_transaksi' => $request['kode_transaksi'],
                'tgl_transaksi' => $request['tgl_transaksi'],
                'user_id' => auth()->user()->id,
                'supplier_id' => $request['supplier_id'],
                'pengirim' => $request['pengirim']
            ]);
            $barangMasuk->save();

            foreach ($request['produk_id'] as $key => $value) {
                array_push($item, ['barang_masuk_id' => $barangMasuk->id, 'produk_id' => $value, 'qty' => $request['qty'][$key]]);
            }

            foreach ($item as $key => $value) {
                $detail = DetailBarangMasuk::create([
                    'barang_masuk_id' => $barangMasuk->id,
                    'produk_id' => $item[$key]['produk_id'],
                    'qty' => $item[$key]['qty'],
                ]);

                $produk  = Produk::find($item[$key]['produk_id']);
                $produk->stok += ($item[$key]['qty']);
                $produk->update();
            }

            return  $barangMasuk->id;
        });

        return redirect()->route('app.action.cetakbarangmasuk', [$id]);

    }

    public function cetak($id)
    {
        $data = DB::table('barang_masuks')
            ->select([
                'barang_masuks.id',
                'kode_transaksi',
                'tgl_transaksi',
                'user_id',
                'supplier_id',
                'pengirim',
                'suppliers.nama_supplier',
                'users.name'
            ])
            ->leftJoin('users', 'users.id', '=', 'barang_masuks.user_id')
            ->leftJoin('suppliers', 'suppliers.id', '=', 'barang_masuks.supplier_id')
            ->where(['barang_masuks.id' => $id])
            ->first();

        $detail = DB::table('detail_barang_masuks')
                ->select([
                    'produk_id',
                    'qty',
                    'produks.nama_produk'
                ])
                ->leftJoin('produks', 'produks.id', '=', 'detail_barang_masuks.produk_id')
                ->where(['barang_masuk_id' => $data->id])
                ->get();

        return view('app.transaksi.barang_masuk.cetak', ['data' => $data, 'detail' => $detail]);
    }

    public function update(Request $request)
    {

    }
}
