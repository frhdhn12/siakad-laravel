<form action="{{ isset($mataKuliah) ? route('matakuliah.update', $mataKuliah->kode_mk) : route('matakuliah.store') }}" method="POST">
    @csrf
    @if(isset($mataKuliah))
        @method('PUT')
    @endif

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label fw-semibold">Kode MK</label>
            <input type="text" name="kode_mk" class="form-control @error('kode_mk') is-invalid @enderror" value="{{ old('kode_mk', $mataKuliah->kode_mk ?? '') }}" required>
            @error('kode_mk')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Nama Mata Kuliah</label>
            <input type="text" name="nama_mk" class="form-control @error('nama_mk') is-invalid @enderror" value="{{ old('nama_mk', $mataKuliah->nama_mk ?? '') }}" required>
            @error('nama_mk')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label fw-semibold">SKS</label>
            <input type="number" name="sks" class="form-control @error('sks') is-invalid @enderror" value="{{ old('sks', $mataKuliah->sks ?? '') }}" required>
            @error('sks')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ url('/mata-kuliah') }}" class="btn btn-secondary">Batal</a>
    </div>
</form>