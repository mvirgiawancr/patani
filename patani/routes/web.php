<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;

// Halaman utama
Route::get('/', function () {
    return view('home');
});

// Halaman petani
Route::get('/petani', function () {
    return view('petani'); // Pastikan file petani.blade.php ada
});

// Rute untuk mengelola produk
Route::get('produk/create', [ProdukController::class, 'create'])->name('produk.create');
Route::post('produk/store', [ProdukController::class, 'store'])->name('produk.store');


// Menampilkan halaman produk
Route::get('/petani', [ProdukController::class, 'index'])->name('produk.index');
