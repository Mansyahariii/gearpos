<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Guest routes (not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kategori - accessible by manajer, staf_gudang
    Route::middleware('role:manajer,staf_gudang')->group(function () {
        Route::resource('kategori', KategoriController::class)->parameters([
            'kategori' => 'kategori:kategori_id'
        ]);
    });

    // Barang - accessible by manajer, staf_gudang
    Route::middleware('role:manajer,staf_gudang')->group(function () {
        Route::resource('barang', BarangController::class)->parameters([
            'barang' => 'barang:barang_id'
        ]);
    });

    // Transaksi (POS) - accessible by kasir
    Route::middleware('role:kasir')->group(function () {
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    });

    // Transaksi history - kasir, manajer, pemilik
    Route::middleware('role:kasir,manajer,pemilik')->group(function () {
        Route::get('/transaksi/riwayat', [TransaksiController::class, 'riwayat'])->name('transaksi.riwayat');
        Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])
            ->name('transaksi.show')
            ->where('transaksi', '[0-9]+');
        Route::post('/transaksi/{transaksi}/batal', [TransaksiController::class, 'batal'])->name('transaksi.batal');
    });

    // Pembelian (Stock In) - accessible by staf_gudang
    Route::middleware('role:staf_gudang')->group(function () {
        Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian.index');
        Route::get('/pembelian/create', [PembelianController::class, 'create'])->name('pembelian.create');
        Route::post('/pembelian', [PembelianController::class, 'store'])->name('pembelian.store');
        Route::get('/pembelian/{pembelian}', [PembelianController::class, 'show'])
            ->name('pembelian.show')
            ->where('pembelian', '[0-9]+');
    });

    // Laporan - accessible by manajer, pemilik
    Route::middleware('role:manajer,pemilik')->group(function () {
        Route::get('/laporan/penjualan', [LaporanController::class, 'penjualan'])->name('laporan.penjualan');
        Route::get('/laporan/stok', [LaporanController::class, 'stok'])->name('laporan.stok');
    });

    // Laporan Keuangan - only pemilik
    Route::middleware('role:pemilik')->group(function () {
        Route::get('/laporan/keuangan', [LaporanController::class, 'keuangan'])->name('laporan.keuangan');
    });
});
