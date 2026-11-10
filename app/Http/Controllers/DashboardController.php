<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\Krs;

class DashboardController extends Controller
{

    public function index(): View
    {
        $totalMahasiswa  = Mahasiswa::count();
        $totalDosen      = Dosen::count();
        $totalMataKuliah = MataKuliah::count();
        $totalKrsAktif   = Krs::count();
        $rataRataSks = 0;
        $krsList = Krs::with('mataKuliah')->get();
        if ($krsList->count() > 0) {
            $totalSksAll = $krsList->sum(function ($item) {
                return $item->mataKuliah->sum('sks');
            });
            $rataRataSks = round($totalSksAll / $krsList->count(), 1);
        }

        $statistik = [
            [
                'judul'  => 'Mahasiswa', 
                'jumlah' => $totalMahasiswa, 
                'ikon'   => 'bi-mortarboard-fill', 
                'warna'  => 'primary'
            ],
            [
                'judul'  => 'Dosen', 
                'jumlah' => $totalDosen, 
                'ikon'   => 'bi-person-badge-fill', 
                'warna'  => 'success'
            ],
            [
                'judul'  => 'Mata Kuliah', 
                'jumlah' => $totalMataKuliah, 
                'ikon'   => 'bi-book-fill', 
                'warna'  => 'warning'
            ],
            [
                'judul'  => 'KRS Aktif', 
                'jumlah' => $totalKrsAktif, 
                'ikon'   => 'bi-journal-check', 
                'warna'  => 'info'
            ],
            [
                'judul'  => 'Rata-rata SKS', 
                'jumlah' => $rataRataSks, 
                'ikon'   => 'bi-bar-chart', 
                'warna'  => 'secondary'
            ],
        ];

        $kolomKrs = [
            'nim'    => 'NIM', 
            'nama'   => 'Nama Mahasiswa', 
            'sks'    => 'SKS', 
            'status' => 'Status'
        ];
        $krsTerbaruData = Krs::with(['mahasiswa', 'mataKuliah'])->latest()->take(5)->get();

        $krsTerbaru = $krsTerbaruData->map(function ($item) {
            return [
                'nim'    => $item->mahasiswa->nim ?? '-',
                'nama'   => $item->mahasiswa->nama ?? '-',
                'sks'    => $item->mataKuliah->sum('sks') ?? 0,
                'status' => $item->status ?? 'Disetujui',
            ];
        });

        $statusKrs = [
            ['label' => 'Disetujui', 'persen' => 70, 'warna' => 'success'],
            ['label' => 'Menunggu',  'persen' => 22, 'warna' => 'warning'],
            ['label' => 'Ditolak',   'persen' => 8,  'warna' => 'danger'],
        ];

        return view('dashboard', compact(
            'statistik', 
            'kolomKrs', 
            'krsTerbaru', 
            'statusKrs'
        ));
    }
}