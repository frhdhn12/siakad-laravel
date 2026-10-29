<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class MahasiswaController extends Controller
{
    public function index(): View
    {
        $kolom = [
            'nim' => 'NIM', 'nama' => 'Nama Lengkap',
            'angkatan' => 'Angkatan', 'email' => 'Email',
            'status' => 'Status',
        ];

        $mahasiswa = [
            ['nim' => '2401001', 'nama' => 'Ahmad Fauzi', 'angkatan' => 2024, 'email' => 'ahmad.fauzi@contoh.ac.id', 'status' => 'Aktif'],
            ['nim' => '2401002', 'nama' => 'Siti Rahmawati', 'angkatan' => 2024, 'email' => 'siti.rahmawati@contoh.ac.id', 'status' => 'Aktif'],
            ['nim' => '2301005', 'nama' => 'Budi Santoso', 'angkatan' => 2023, 'email' => 'budi.santoso@contoh.ac.id', 'status' => 'Aktif'],
            ['nim' => '2301012', 'nama' => 'Dewi Lestari', 'angkatan' => 2023, 'email' => 'dewi.lestari@contoh.ac.id', 'status' => 'Drop Out'],
            ['nim' => '2201020', 'nama' => 'Rizky Pratama', 'angkatan' => 2022, 'email' => 'rizky.pratama@contoh.ac.id', 'status' => 'Lulus'],
        ];

        return view('mahasiswa.index', compact('kolom', 'mahasiswa'));
    }

    public function show($nim): View
    {
        $daftarMahasiswa = [
            '2401001' => ['nim' => '2401001', 'nama' => 'Ahmad Fauzi', 'prodi' => 'D3 Teknik Informatika', 'angkatan' => 2024, 'email' => 'ahmad.fauzi@contoh.ac.id', 'status' => 'Aktif'],
            '2401002' => ['nim' => '2401002', 'nama' => 'Siti Rahmawati', 'prodi' => 'D3 Teknik Informatika', 'angkatan' => 2024, 'email' => 'siti.rahmawati@contoh.ac.id', 'status' => 'Aktif'],
            '2301005' => ['nim' => '2301005', 'nama' => 'Budi Santoso', 'prodi' => 'D3 Teknik Informatika', 'angkatan' => 2023, 'email' => 'budi.santoso@contoh.ac.id', 'status' => 'Aktif'],
            '2301012' => ['nim' => '2301012', 'nama' => 'Dewi Lestari', 'prodi' => 'D3 Teknik Informatika', 'angkatan' => 2023, 'email' => 'dewi.lestari@contoh.ac.id', 'status' => 'Drop Out'],
            '2201020' => ['nim' => '2201020', 'nama' => 'Rizky Pratama', 'prodi' => 'D3 Teknik Informatika', 'angkatan' => 2022, 'email' => 'rizky.pratama@contoh.ac.id', 'status' => 'Lulus'],
        ];

        if (!array_key_exists($nim, $daftarMahasiswa)) {
            abort(404);
        }

        $mahasiswa = $daftarMahasiswa[$nim];

        return view('mahasiswa.show', compact('mahasiswa'));
    }
}