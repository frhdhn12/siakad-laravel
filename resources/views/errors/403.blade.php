@extends('layouts.app')

@section('title', 'Akses Ditolak (403)')

@section('content')
<div class="container text-center py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4">
                <div class="card-body">
                    <div class="display-1 text-danger fw-bold mb-3">403</div>
                    <h1 class="h4 fw-bold mb-3">Akses Ditolak</h1>
                    <p class="text-body-secondary mb-4">
                        Maaf, Anda tidak memiliki hak akses untuk membuka halaman ini karena batasan peran atau otorisasi.
                    </p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        <i class="bi bi-house-door-fill me-1"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection