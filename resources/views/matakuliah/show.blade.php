@extends('layouts.app')

@section('title', 'Detail Mata Kuliah')

@section('content')
    <x-page-header judul="Detail Mata Kuliah" deskripsi="Informasi lengkap data mata kuliah." />

    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white fw-semibold">
                    Kartu Detail Mata Kuliah
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th width="35%">Kode MK</th>
                            <td>: {{ $mataKuliah['kode_mk'] }}</td>
                        </tr>
                        <tr>
                            <th>Nama Mata Kuliah</th>
                            <td>: {{ $mataKuliah['nama_mk'] }}</td>
                        </tr>
                        <tr>
                            <th>SKS</th>
                            <td>: {{ $mataKuliah['sks'] }}</td>
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