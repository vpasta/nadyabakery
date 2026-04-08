<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SettingsController;
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

    // Route untuk Riwayat Transaksi
    Route::get('/riwayat', [TransaksiController::class, 'riwayat']);
    Route::delete('/riwayat/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');

    // Halaman & CRUD Stok Produk
    Route::get('/stok', [ProdukController::class, 'index']);
    Route::post('/stok', [ProdukController::class, 'store']); // Untuk Simpan Baru
    Route::put('/stok/{id}', [ProdukController::class, 'update']); // Untuk Update
    Route::delete('/stok/{id}', [ProdukController::class, 'destroy']); // Untuk Hapus

    // Proses Checkout
    Route::post('/checkout', [TransaksiController::class, 'prosesCheckout']);

    Route::get('/pengaturan', [SettingsController::class, 'index']);
    Route::post('/pengaturan/profile', [SettingsController::class, 'updateProfile']);
    Route::post('/pengaturan/qris', [SettingsController::class, 'updateQris']);
    Route::post('/pengaturan/kategori', [SettingsController::class, 'storeKategori'])->name('kategori.store');
    Route::put('/pengaturan/kategori/{id}', [SettingsController::class, 'updateKategori'])->name('kategori.update');
    Route::delete('/pengaturan/kategori/{id}', [SettingsController::class, 'destroyKategori'])->name('kategori.destroy');
});