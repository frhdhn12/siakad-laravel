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
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0" id="mahasiswa-table">
                <thead class="table-light">
                    <tr>
                        <th width="50px">No.</th>
                        <th>NIM</th>
                        <th>Nama Lengkap</th>
                        <th>Jenis Kelamin</th>
                        <th>Angkatan</th>
                        <th>Program Studi</th>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Inisialisasi Yajra DataTables
    $('#mahasiswa-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('mahasiswa.data') }}",
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
        language: {
            lengthMenu: "Tampilkan _MENU_",
            zeroRecords: "Tidak ditemukan data yang sesuai",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
            infoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
            search: "Cari:",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'nim', name: 'nim' },
            { data: 'nama', name: 'nama' },
            { data: 'jenis_kelamin', name: 'jenis_kelamin' },
            { data: 'angkatan', name: 'angkatan' },
            { data: 'program_studi', name: 'program_studi' },
            { data: 'email', name: 'email' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Menggunakan document-on agar tombol dinamis dari DataTables pasti terbaca
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        
        var form = $(this).closest('form');
        var nama = $(this).data('nama');

        Swal.fire({
            title: 'Hapus data mahasiswa?',
            text: "Data " + nama + " akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush