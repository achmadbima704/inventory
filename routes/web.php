<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // dd(Auth::user()->roles == 'admin');
    if (Auth::check()) {
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('app.admin.dashboard');
        } else {
            return redirect()->route('app.user.home');
        }
    }
    return view('app.auth.login');
})->name('app.view.login');

Route::post('/login', [AuthController::class, 'login'])->name('app.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('app.logout');

Route::group(['middleware' => 'auth'], function () {
    Route::post('/data-master/updatepetugas', [PetugasController::class, 'update'])->name('app.action.updatepetugas');

    Route::group(['middleware' => 'role:admin'], function () {
        Route::get('/dashboard', function () {
            return view('app.dashboard');
        })->name('app.admin.dashboard');

        // Master Produk
        Route::get('/data-master/data-produk', [ProdukController::class, 'index'])->name('app.view.dataproduk');
        Route::get('/data-master/get-produk', [ProdukController::class, 'getProduk'])->name('app.data.produk');
        Route::post('/data-master/produk', [ProdukController::class, 'store'])->name('app.action.addproduk');
        Route::post('/data-master/updateproduk', [ProdukController::class, 'update'])->name('app.action.updateproduk');

        // Master Kategori
        Route::get('/data-master/kategori', [KategoriController::class, 'index'])->name('app.view.datakategori');
        Route::get('/data/master/get-kategori', [KategoriController::class, 'getKategori'])->name('app.data.kategori');
        Route::post('/data-master/kategori', [KategoriController::class, 'store'])->name('app.action.addkategori');
        Route::post('/data-master/updatekategori', [KategoriController::class, 'update'])->name('app.action.updatekategori');

        // Master Customer
        Route::get('/data-master/customer', [CustomerController::class, 'index'])->name('app.view.datacustomer');
        Route::get('/data-master/get-customer', [CustomerController::class, 'getCustomer'])->name('app.data.customer');
        Route::post('/data-master/customer', [CustomerController::class, 'store'])->name('app.action.addcustomer');
        Route::post('/data-master/updatecustomer', [CustomerController::class, 'update'])->name('app.action.updatecustomer');

        // Master Petugas
        Route::get('/data-master/petugas', [PetugasController::class, 'index'])->name('app.view.datapetugas');
        Route::get('/data-petugas/get-petugas', [PetugasController::class, 'getPetugas'])->name('app.data.petugas');
        Route::post('/data-master/petugas', [PetugasController::class, 'store'])->name('app.action.addpetugas');

        // Master Supplier
        Route::get('/data-master/supplier', [SupplierController::class, 'index'])->name('app.view.datasupplier');
        Route::get('/data-master/get-supplier', [SupplierController::class, 'getSupplier'])->name('app.data.supplier');
        Route::post('/data-master/supplier', [SupplierController::class, 'store'])->name('app.action.addsupplier');
        Route::post('/data-master/updatesupplier', [SupplierController::class, 'update'])->name('app.action.updatesupplier');

    });

    Route::group(['middleware' => 'role:user'], function () {
        Route::get('/home', function () {
            return view('home');
        })->name('app.user.home');
    });

    // Profile
    Route::get('/profile', [AuthController::class, 'profile'])->name('app.profile');

    // Transaksi Barang Masuk
    Route::get('/transaksi/barang-masuk', [BarangMasukController::class, 'index'])->name('app.view.barangmasuk');
    Route::post('/transaksi/barang-masuk', [BarangMasukController::class, 'store'])->name('app.action.addbarangmasuk');
    Route::get('/transaksi/barang-masuk/cetak/{id}', [BarangMasukController::class, 'cetak'])->name('app.action.cetakbarangmasuk');

    // Transaksi Barang Keluar
    Route::get('/transaksi/barang-keluar', [BarangKeluarController::class, 'index'])->name('app.view.barangkeluar');
    Route::post('/transaksi/barang-keluar', [BarangKeluarController::class, 'store'])->name('app.action.addbarangkeluar');
    Route::get('/transaksi/barang-keluar/cetak/{id}', [BarangKeluarController::class, 'cetak'])->name('app.action.cetakbarangkeluar');
});




