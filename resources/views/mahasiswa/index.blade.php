@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('content')
<x-page-header judul="Data Mahasiswa">
    <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#formMahasiswa">
        <i class="bi bi-plus-lg"></i> Tambah Mahasiswa
    </button>
</x-page-header>

<div class="collapse mb-4" id="formMahasiswa">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-body fw-semibold">Form Mahasiswa</div>
        <div class="card-body">
            @include('mahasiswa._form')
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-body fw-semibold">Daftar Mahasiswa</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0" id="mahasiswa-table">
                <thead class="table-light">
                    <tr>
                        <th width="50px">No.</th>
                        <th>NIM</th>
                        <th>Nama Lengkap</th>
                        <th>Angkatan</th>
                        <th>Email</th>
                        <th width="180px">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('#mahasiswa-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('mahasiswa.data') }}",
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]], // Mengubah teks "All" atau satuan belakang
            language: {
                "lengthMenu": "Tampilkan _MENU_", // Kata "entri" dihapus dari sini agar tidak double/muncul di belakang
                "zeroRecords": "Tidak ditemukan data yang sesuai",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                "infoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'nim', name: 'nim' },
                { data: 'nama', name: 'nama' },
                { data: 'angkatan', name: 'angkatan' },
                { data: 'email', name: 'email' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });
</script>
@endpush