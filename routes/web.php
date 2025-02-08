<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\PesananController;

// Halaman utama (home)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rute untuk halaman petani
Route::get('/petani', [ProdukController::class, 'index'])->name('petani'); // Hapus rute kedua untuk /petani

// Rute untuk login dan register
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

// Rute untuk logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute untuk produk
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index'); // Halaman daftar produk
Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create'); // Form tambah produk
Route::post('/produk/store', [ProdukController::class, 'store'])->name('produk.store'); // Simpan produk baru
Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit'); // Form edit produk
Route::put('/produk/update/{id}', [ProdukController::class, 'update'])->name('produk.update'); // Update produk
Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy'); // Hapus produk
Route::get('/produk/{id}', [ProdukController::class, 'show'])->where('id', '[0-9]+')->name('produk.show'); // Detail produk

// Rute untuk keranjang
Route::post('/keranjang/tambah-db/{produk_id}', [HomeController::class, 'tambahKeranjangDB'])->name('keranjang.tambahDB'); // Pastikan fungsi ini ada di HomeController
Route::post('/keranjang/tambah/{id_produk}', [HomeController::class, 'tambahKeranjang'])->name('keranjang.tambah'); // Tambah ke keranjang
Route::post('/keranjang/update', [HomeController::class, 'updateJumlah'])->name('keranjang.update');

// checkout
Route::post('/checkout', [HomeController::class, 'checkout'])->name('checkout');



Route::post('/keranjang/delete', [HomeController::class, 'deleteKeranjang'])->name('keranjang.delete');


// upload 
Route::post('/pesanan/{id}/upload-payment', [HomeController::class, 'uploadPayment'])->name('uploadPayment');

// untuk update resi
Route::post('/update-resi/{idPesanan}', [ProdukController::class, 'updateResi'])->name('updateResi');

//selesaikan pesanan
Route::post('/selesaikan-pesanan/{id}', [HomeController::class, 'selesaikanPesanan']);


// save location
Route::post('/save-location', [HomeController::class, 'storeAlamat'])->name('save-location');
// untuk petani
Route::post('/save-location-petani', [ProdukController::class, 'storeAlamatPatani'])->name('save-location-petani');

// update setting
// user
Route::put('/user/settings', [HomeController::class, 'updateSettings'])->name('user.updateSettings');
// patani
Route::put('/patani/settings', [ProdukController::class, 'updateSettingspatani'])->name('patani.updateSettings');


// Rute untuk pencarian produk (AJAX request tetap menggunakan fungsi index)
Route::get('/cari-produk', [HomeController::class, 'cari'])->name('produk.cari');
Route::get('/cari-produk-petani', [ProdukController::class, 'cariPetani'])->name('produk.cariPetani');

// untuk cari berdasarkan lokasi
// Route untuk pencarian berdasarkan lokasi

Route::get('/search-by-location', [HomeController::class, 'searchByLocation'])->name('produk.cari.lokasi');




