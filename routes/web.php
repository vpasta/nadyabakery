<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AuthController;
use App\Models\Produk;
use App\Models\Kategori;

// --- RUTE PUBLIK (Bisa diakses siapa saja) ---
Route::get('/', function () {
    return view('bakery-home');
});

// Rute Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login'); 
Route::post('/login', [AuthController::class, 'prosesLogin']);
Route::get('/logout', [AuthController::class, 'logout']);

// --- RUTE TERKUNCI (Hanya untuk yang sudah login) ---
Route::middleware('auth')->group(function () {
    
    // Kasir Desktop
    Route::get('/kasir', function () {
        $kategoris = Kategori::all();
        $produks = Produk::all();
        return view('bakery-cashier', compact('kategoris', 'produks'));
    });

    // Kasir Mobile
    Route::get('/kasir-mobile', function () {
        $kategoris = Kategori::all();
        $produks = Produk::all();
        return view('bakery-cashier-mobile', compact('kategoris', 'produks'));
    });

    // Route untuk Riwayat Transaksi
    Route::get('/riwayat', [TransaksiController::class, 'riwayat']);

    // Proses Checkout
    Route::post('/checkout', [TransaksiController::class, 'prosesCheckout']);
});