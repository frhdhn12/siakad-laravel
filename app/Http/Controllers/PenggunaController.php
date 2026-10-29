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
            'nama' => 'Nama', 'email' => 'Email', 'role' => 'Peran'
        ];


        $pengguna = User::orderBy('nama')
            ->get(['name', 'email', 'role'])
            ->toArray();
        
        return view('pengguna.index', compact('kolom', 'pengguna'));
}
}