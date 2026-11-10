@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<x-page-header judul="Dashboard" deskripsi="Ringkasan data akademik sistem informasi." />

<!-- Baris Kartu Statistik -->
<div class="row g-3 mb-4">
    @foreach($statistik as $stat)
        <div class="col-12 col-sm-6 col-md-4 col-xl">
            <x-stat-card :judul="$stat['judul']" :angka="$stat['jumlah']" :icon="$stat['ikon']" :warna="$stat['warna']" />
        </div>
    @endforeach
</div>

<div class="row g-4">
    <!-- Tabel KRS Terbaru -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-body fw-semibold">KRS Terbaru</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">#</th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>SKS</th>
                                <th class="pe-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($krsTerbaru as $index => $krs)
                                <tr>
                                    <td class="ps-3">{{ $index + 1 }}</td>
                                    <td>
                                        <a href="{{ route('mahasiswa.index') }}" class="text-decoration-none fw-semibold">
                                            {{ $krs['nim'] }}
                                        </a>
                                    </td>
                                    <td>{{ $krs['nama'] }}</td>
                                    <td>{{ $krs['sks'] }}</td>
                                    <td class="pe-3">
                                        <span class="badge bg-{{ $krs['status'] == 'Disetujui' ? 'success' : ($krs['status'] == 'Pending' || $krs['status'] == 'Menunggu' ? 'warning text-dark' : 'danger') }}">
                                            {{ $krs['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted fst-italic">Belum ada data KRS terbaru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Status KRS (Progress Bar) -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-body fw-semibold">Status KRS</div>
            <div class="card-body">
                @foreach ($statusKrs as $status)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small fw-semibold">{{ $status['label'] }}</span>
                            <span class="small text-muted">{{ $status['persen'] }}%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-{{ $status['warna'] }}" role="progressbar" style="width: {{ $status['persen'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection