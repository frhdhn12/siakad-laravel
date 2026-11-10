@extends('layouts.app')

@section('title', 'Tambah Mata Kuliah')

@section('content')
<x-page-header judul="Tambah Mata Kuliah" />

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @include('matakuliah._form')
    </div>
</div>
@endsection