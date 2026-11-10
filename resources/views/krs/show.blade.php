@extends('layouts.app')

@section('title', 'Detail Kartu Rencana Studi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <x-page-header judul="Detail Kartu Rencana Studi" deskripsi="Informasi lengkap data KRS mahasiswa." />
    
    <a href="{{ route('krs.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-body fw-semibold">Informasi Mahasiswa</div>
    <div class="card-body">
        <table class="table table-borderless mb-0">
            <tr>
                <td width="20%" class="fw-semibold text-muted">NIM</td>
                <td width="2%">:</td>
                <td>{{ $krs->mahasiswa->nim ?? '-' }}</td>
            </tr>
            <tr>
                <td class="fw-semibold text-muted">Nama Mahasiswa</td>
                <td>:</td>
                <td>{{ $krs->mahasiswa->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="fw-semibold text-muted">Tahun Akademik</td>
                <td>:</td>
                <td>{{ $krs->tahun_akademik }}</td>
            </tr>
            <tr>
                <td class="fw-semibold text-muted">Semester</td>
                <td>:</td>
                <td>{{ $krs->semester ?? '-' }}</td>
            </tr>
            <tr>
                <td class="fw-semibold text-muted">Status</td>
                <td>:</td>
                <td>
                    @if(($krs->status ?? 'Disetujui') == 'Ditolak')
                        <span class="badge bg-danger">Ditolak</span>
                    @elseif(($krs->status ?? 'Disetujui') == 'Pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @else
                        <span class="badge bg-success">Disetujui</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-body fw-semibold">Daftar Mata Kuliah yang Diambil</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th>Kode MK</th>
                        <th>Nama Mata Kuliah</th>
                        <th class="text-center">SKS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($krs->mataKuliah as $index => $mk)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><code>{{ $mk->kode_mk ?? '-' }}</code></td>
                        <td>{{ $mk->nama_mk }}</td>
                        <td class="text-center">{{ $mk->sks }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Tidak ada mata kuliah yang diambil pada KRS ini.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Total SKS :</td>
                        <td class="text-center fw-bold">
                            {{ $krs->mataKuliah->sum('sks') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection