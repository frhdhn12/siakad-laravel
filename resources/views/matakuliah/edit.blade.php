@extends('layouts.app')
@section('title', 'Edit Mata Kuliah')
@section('content')
<x-page-header judul="Edit Mata Kuliah" />
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @include('matakuliah._form')
    </div>
</div>
@endsection