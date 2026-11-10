@extends('layouts.app')

@section('title', 'Data Mata Kuliah')

@section('content')
<x-page-header judul="Data Mata Kuliah">
    <a href="{{ route('matakuliah.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Mata Kuliah
    </a>
</x-page-header>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-body fw-semibold">Daftar Mata Kuliah</div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0" id="matakuliah-table">
                <thead class="table-light">
                    <tr>
                        <th width="50px">No.</th>
                        <th>Kode MK</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
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
    $('#matakuliah-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('matakuliah.data') }}",
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
            { data: 'kode_mk', name: 'kode_mk' },
            { data: 'nama_mk', name: 'nama_mk' },
            { data: 'sks', name: 'sks' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Event Delegation global untuk tombol hapus dinamis Yajra DataTables
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        
        var form = $(this).closest('form');
        var nama = $(this).data('nama');

        Swal.fire({
            title: 'Hapus data mata kuliah?',
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