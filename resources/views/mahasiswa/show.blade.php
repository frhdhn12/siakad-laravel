@extends('layouts.app')

@section('title', 'Detail Mahasiswa')

@section('content')
    <x-page-header judul="Detail Mahasiswa" deskripsi="Informasi lengkap data mahasiswa." />

    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white fw-semibold">
                    Kartu Detail Mahasiswa
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th width="35%">NIM</th>
                            <td>: {{ $mahasiswa['nim'] }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>: {{ $mahasiswa['nama'] }}</td>
                        </tr>
                        <tr>
                            <th>Program Studi</th>
                            <td>: {{ $mahasiswa['prodi'] }}</td>
                        </tr>
                        <tr>
                            <th>Angkatan</th>
                            <td>: {{ $mahasiswa['angkatan'] }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer bg-body">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection