<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class PenggunaController extends Controller
{
    /**
     * Menampilkan daftar pengguna.
     */
    public function index(): View
    {
        $kolom = [
            'name'           => 'Nama',
            'email'          => 'Email',
            'role'           => 'Peran',
            'last_login_at'  => 'Login Terakhir',
        ];

        $users = User::orderBy('name')->get();

        $pengguna = $users->map(function ($item) {
            return [
                'name'          => $item->name,
                'email'         => $item->email,
                'role'          => $item->role,
                'last_login_at' => $item->last_login_at 
                    ? Carbon::parse($item->last_login_at)->format('d-m-Y H:i:s') 
                    : 'Belum pernah login',
            ];
        });

        return view('pengguna.index', compact('kolom', 'pengguna'));
    }
}