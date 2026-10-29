@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <x-page-header judul="Dashboard" deskripsi="Ringkasan data akademik (data sementara)." />

    <div class="row g-3 mb-4">
        @foreach ($statistik as $stat)
            <div class="col-12 col-sm-6 col-md-4 col-xl">
                <x-stat-card :judul="$stat['judul']" :jumlah="$stat['jumlah']" :ikon="$stat['ikon']" :warna="$stat['warna']" />
            </div>
        @endforeach
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-body fw-semibold">KRS Terbaru</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>NIM</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>SKS</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($krsTerbaru as $index => $krs)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <a href="{{ route('mahasiswa.show', $krs['nim']) }}" class="text-decoration-none fw-semibold">
                                                {{ $krs['nim'] }}
                                            </a>
                                        </td>
                                        <td>{{ $krs['nama'] }}</td>
                                        <td>{{ $krs['sks'] }}</td>
                                        <td>
                                            <span class="badge bg-{{ $krs['status'] == 'Disetujui' ? 'success' : ($krs['status'] == 'Menunggu' ? 'warning' : 'danger') }}">
                                                {{ $krs['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-body fw-semibold">Status KRS</div>
                <div class="card-body">
                    @foreach ($statusKrs as $status)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small">{{ $status['label'] }}</span>
                                <span class="small text-muted">{{ $status['persen'] }}%</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-{{ $status['warna'] }}" style="width: {{ $status['persen'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection