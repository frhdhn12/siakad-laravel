<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DosenController extends Controller
{
    public function index(): View {
        $kolom = ['NIP' => 'NIP', 'nama' => 'Nama Dosen', 'email' => 'Email'];
        $dosen = [
            ['NIP' => '198001', 'nama' => 'Dr. Aris Setiawan, M.Kom.', 'email' => 'aris@contoh.ac.id'],
            ['NIP' => '198002', 'nama' => 'Siti Aminah, M.T.', 'email' => 'aminah@contoh.ac.id']
        ];
        return view('dosen.index', compact('kolom', 'dosen'));
    }
}