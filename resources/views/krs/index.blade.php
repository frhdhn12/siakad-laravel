@extends('layouts.app')

@section('title', 'Daftar Kartu Rencana Studi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <x-page-header judul="Kartu Rencana Studi" deskripsi="Daftar KRS mahasiswa." />
    <a href="{{ route('krs.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah KRS
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-body fw-semibold">Daftar KRS</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th class="text-center">SKS</th>
                        <th class="text-center">Status</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($krs as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><code>{{ $item['nim'] }}</code></td>
                        <td>{{ $item['nama'] }}</td>
                        <td class="text-center">{{ $item['sks'] }}</td>
                        <td class="text-center">
                            {!! $item['status'] !!}
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                {!! $item['aksi'] !!}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada data KRS.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection