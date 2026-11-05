<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PenggunaController extends Controller
{
    public function index(): View
    {
        $kolom = [
            'name'          => 'Nama', 
            'email'         => 'Email', 
            'role'          => 'Peran',
            'last_login_at' => 'Login Terakhir', // Menambahkan kolom baru
        ];

        $pengguna = User::orderBy('name')
            ->get(['name', 'email', 'role', 'last_login_at']) // Menyertakan last_login_at
            ->toArray();

        return view('pengguna.index', compact('kolom', 'pengguna'));
    }
}