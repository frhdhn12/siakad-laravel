<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\KrsController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\PenggunaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email'     => ['required', 'email'],
            'password'  => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    })->name('login.attempt');
});

Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('/', fn () => redirect()->route('dashboard'));
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/mahasiswa/data', [MahasiswaController::class, 'data'])->name('mahasiswa.data');
    Route::resource('mahasiswa', MahasiswaController::class);

    Route::get('/dosen/data', [DosenController::class, 'data'])->name('dosen.data');
    Route::middleware('role:admin')->group(function () {
        Route::resource('dosen', DosenController::class)
            ->except(['index', 'show']);
    });
    Route::resource('dosen', DosenController::class)
        ->only(['index', 'show']);

    // Route Mata Kuliah (disesuaikan dengan penamaan tanpa strip agar sesuai dengan view)
    Route::get('/mata-kuliah/data', [MataKuliahController::class, 'data'])->name('matakuliah.data');
    Route::resource('mata-kuliah', MataKuliahController::class)->names([
        'index'   => 'matakuliah.index',
        'create'  => 'matakuliah.create',
        'store'   => 'matakuliah.store',
        'show'    => 'matakuliah.show',
        'edit'    => 'matakuliah.edit',
        'update'  => 'matakuliah.update',
        'destroy' => 'matakuliah.destroy',
    ]);

    Route::resource('krs', KrsController::class);

    Route::get('/pengguna', [PenggunaControlle::class, 'index'])
        ->middleware('role:admin')
        ->name('pengguna.index');

    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
});