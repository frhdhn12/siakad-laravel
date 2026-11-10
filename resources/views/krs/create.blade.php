@extends('layouts.app')

@section('title', 'Tambah Kartu Rencana Studi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <x-page-header judul="Tambah Kartu Rencana Studi" deskripsi="Buat data KRS baru untuk mahasiswa." />
    
    <a href="{{ route('krs.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-body fw-semibold">Form Tambah KRS</div>
    <div class="card-body">
        <form action="{{ route('krs.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="mahasiswa_id" class="form-label">Mahasiswa</label>
                <select name="mahasiswa_id" id="mahasiswa_id" class="form-select" required>
                    <option value="">-- Pilih Mahasiswa --</option>
                    @foreach($mahasiswas as $mhs)
                        <option value="{{ $mhs->id }}" {{ old('mahasiswa_id') == $mhs->id ? 'selected' : '' }}>
                            {{ $mhs->nim }} - {{ $mhs->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="tahun_akademik" class="form-label">Tahun Akademik</label>
                <input type="text" name="tahun_akademik" id="tahun_akademik" class="form-control" value="{{ old('tahun_akademik') }}" placeholder="Contoh: 2024/2025" required>
            </div>

            <div class="mb-3">
                <label for="semester" class="form-label">Semester</label>
                <select name="semester" id="semester" class="form-select" required>
                    <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="Disetujui" {{ old('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Ditolak" {{ old('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Pilih Mata Kuliah</label>
                <div class="row">
                    @foreach($mataKuliahs as $mk)
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="mata_kuliah_id[]" value="{{ $mk->id }}" id="mk_{{ $mk->id }}"
                                    {{ is_array(old('mata_kuliah_id')) && in_array($mk->id, old('mata_kuliah_id')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="mk_{{ $mk->id }}">
                                    {{ $mk->nama_mk }} ({{ $mk->sks }} SKS)
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                @error('mata_kuliah_id')
                    <div class="text-danger mt-2 small">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('krs.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection