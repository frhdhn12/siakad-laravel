<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MataKuliahController extends Controller
{
    public function index(): View {
        $kolom = ['kode' => 'Kode MK', 'nama' => 'Mata Kuliah', 'sks' => 'SKS'];
        $matakuliah = [
            ['kode' => 'IF2101', 'nama' => 'Pemrograman Web', 'sks' => 3],
            ['kode' => 'IF2102', 'nama' => 'Basis Data', 'sks' => 4]
        ];
        return view('matakuliah.index', compact('kolom', 'matakuliah'));
    }
}