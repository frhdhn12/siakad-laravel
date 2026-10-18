<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\KrsController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use Illuminate\Support\Facades\Route;

// Halaman awal diarahkan ke dashboard
Route::get('/', fn () => redirect()->route('dashboard'));

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
Route::get('/mahasiswa', [MahasiswaController::class, 'index'])
    ->name('mahasiswa.index');
Route::get('/dosen', [DosenController::class, 'index'])
    ->name('dosen.index');
Route::get('/mata-kuliah', [MataKuliahController::class, 'index'])
    ->name('matakuliah.index');
Route::get('/krs', [KrsController::class, 'index'])
    ->name('krs.index');

// Dari Jobsheet 01, tetap dipertahankan
Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');