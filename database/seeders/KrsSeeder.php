<?php

namespace Database\Seeders;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Database\Seeder;

class KrsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil 10 mahasiswa pertama
        $mahasiswas = Mahasiswa::take(10)->get();

        foreach ($mahasiswas as $mhs) {
            // Buat data KRS untuk setiap mahasiswa
            $krs = Krs::create([
                'mahasiswa_id' => $mhs->id,
                'tahun_akademik' => '2026/2027',
                'semester' => 'Ganjil',
            ]);

            // Ambil 5 ID mata kuliah secara acak
            $mataKuliahIds = MataKuliah::inRandomOrder()->limit(5)->pluck('id');

            // Attach mata kuliah ke relasi krsDetail (melalui relasi mataKuliah())
            $krs->mataKuliah()->attach($mataKuliahIds);
        }
    }
}