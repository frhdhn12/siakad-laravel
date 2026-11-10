@csrf

<div class="mb-3">
    <label for="mahasiswa_id" class="form-label fw-semibold">Mahasiswa</label>
    <select name="mahasiswa_id" id="mahasiswa_id" class="form-select @error('mahasiswa_id') is-invalid @enderror" required>
        <option value="">-- Pilih Mahasiswa --</option>
        @foreach($mahasiswas as $mhs)
            <option value="{{ $mhs->id }}" {{ (isset($krs) && $krs->mahasiswa_id == $mhs->id) ? 'selected' : (old('mahasiswa_id') == $mhs->id ? 'selected' : '') }}>
                {{ $mhs->nim }} - {{ $mhs->nama }}
            </option>
        @endforeach
    </select>
    @error('mahasiswa_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="tahun_akademik" class="form-label fw-semibold">Tahun Akademik</label>
    <input type="text" name="tahun_akademik" id="tahun_akademik" class="form-control @error('tahun_akademik') is-invalid @enderror" value="{{ old('tahun_akademik', $krs->tahun_akademik ?? '2025/2026') }}" placeholder="Contoh: 2025/2026" required>
    @error('tahun_akademik')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="status" class="form-label fw-semibold">Status</label>
    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
        <option value="Disetujui" {{ (isset($krs) && $krs->status == 'Disetujui') ? 'selected' : '' }}>Disetujui</option>
        <option value="Pending" {{ (isset($krs) && $krs->status == 'Pending') ? 'selected' : '' }}>Pending</option>
        <option value="Ditolak" {{ (isset($krs) && $krs->status == 'Ditolak') ? 'selected' : '' }}>Ditolak</option>
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex justify-content-end gap-2">
    <a href="{{ route('krs.index') }}" class="btn btn-secondary">Kembali</a>
    <button type="submit" class="btn btn-primary">Simpan</button>
</div>