<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class KrsController extends Controller
{
    public function index(): View {
        $kolom = ['nim' => 'NIM', 'nama' => 'Nama Mahasiswa', 'sks' => 'SKS', 'status' => 'Status'];
        $krs = [
            ['nim' => '2401001', 'nama' => 'Ahmad Fauzi', 'sks' => 22, 'status' => 'Disetujui'],
            ['nim' => '2401002', 'nama' => 'Siti Rahmawati', 'sks' => 20, 'status' => 'Disetujui']
        ];
        return view('krs.index', compact('kolom', 'krs'));
    }
}