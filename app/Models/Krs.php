<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'tahun_akademik',
        'semester',
    ];

    // Relasi ke Mahasiswa (belongsTo)
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    // Relasi ke Mata Kuliah melalui tabel perantara krs_detail (belongsToMany)
    public function mataKuliah()
    {
        return $this->belongsToMany(MataKuliah::class, 'krs_detail', 'krs_id', 'mata_kuliah_id');
    }
}