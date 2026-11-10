<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;

class KrsController extends Controller
{
    public function index(): View
    {
        $kolom = [
            'nim'     => 'NIM',
            'nama'    => 'Nama Mahasiswa',
            'sks'     => 'SKS',
            'status'  => 'Status',
            'aksi'    => 'Aksi'
        ];

        $krsQuery = Krs::with(['mahasiswa', 'mataKuliah'])->get();

        $krs = $krsQuery->map(function ($item) {
            $totalSks = $item->mataKuliah->sum('sks');

            $statusValue = $item->status ?? 'Disetujui';

            if ($statusValue == 'Ditolak') {
                $statusBadge = '<span class="badge bg-danger">Ditolak</span>';
            } elseif ($statusValue == 'Pending') {
                $statusBadge = '<span class="badge bg-warning text-dark">Pending</span>';
            } else {
                $statusBadge = '<span class="badge bg-success">Disetujui</span>';
            }

            // Tombol Aksi menggunakan Bootstrap Icons
            $actionBtn = '
                <div class="d-flex gap-1">
                    <a href="'.route('krs.show', $item->id).'" class="btn btn-info btn-sm text-white" title="Detail"><i class="bi bi-eye"></i></a>
            ';

            // Tombol Edit & Hapus hanya muncul jika role adalah admin
            if (auth()->check() && auth()->user()->role === 'admin') {
                $actionBtn .= '
                    <a href="'.route('krs.edit', $item->id).'" class="btn btn-warning btn-sm text-white" title="Edit"><i class="bi bi-pencil-square"></i></a>
                    <form action="'.route('krs.destroy', $item->id).'" method="POST" class="d-inline" onsubmit="return confirm(\'Yakin ingin menghapus data ini?\')">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="bi bi-trash"></i></button>
                    </form>
                ';
            }

            $actionBtn .= '</div>';

            return [
                'id'      => $item->id,
                'nim'     => $item->mahasiswa->nim ?? '-',
                'nama'    => $item->mahasiswa->nama ?? '-',
                'sks'     => $totalSks > 0 ? $totalSks : 0,
                'status'  => $statusBadge,
                'aksi'    => $actionBtn,
            ];
        });

        return view('krs.index', compact('kolom', 'krs'));
    }

    public function create(): View
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $mahasiswas = Mahasiswa::all();
        $mataKuliahs = MataKuliah::all();
        return view('krs.create', compact('mahasiswas', 'mataKuliahs'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'mahasiswa_id'    => 'required|exists:mahasiswa,id',
            'tahun_akademik'  => 'required|string',
            'semester'        => 'required|string',
            'status'          => 'nullable|string',
            'mata_kuliah_id'  => 'nullable|array',
        ]);

        // Validasi Batas SKS (Maksimal 24 SKS)
        if ($request->has('mata_kuliah_id')) {
            $totalSks = MataKuliah::whereIn('id', $request->mata_kuliah_id)->sum('sks');
            if ($totalSks > 24) {
                return back()->withErrors(['mata_kuliah_id' => 
                'Total SKS yang dipilih melebihi batas maksimum (24 SKS). Total SKS Anda: ' . $totalSks])->withInput();
            }
        }

        $krs = Krs::create([
            'mahasiswa_id'    => $request->mahasiswa_id,
            'tahun_akademik'  => $request->tahun_akademik,
            'semester'        => $request->semester,
            'status'          => $request->status ?? 'Disetujui',
        ]);

        if ($request->has('mata_kuliah_id')) {
            $krs->mataKuliah()->sync($request->mata_kuliah_id);
        }

        return redirect()->route('krs.index')->with('success', 'Data KRS berhasil ditambahkan!');
    }

    public function show($id): View
    {
        $krs = Krs::with(['mahasiswa', 'mataKuliah'])->findOrFail($id);
        return view('krs.show', compact('krs'));
    }

    public function edit($id): View
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $krs = Krs::with(['mahasiswa', 'mataKuliah'])->findOrFail($id);
        $mahasiswas = Mahasiswa::all();
        $mataKuliahs = MataKuliah::all();
        return view('krs.edit', compact('krs', 'mahasiswas', 'mataKuliahs'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'mahasiswa_id'    => 'required|exists:mahasiswa,id',
            'tahun_akademik'  => 'required|string',
            'semester'        => 'required|string',
            'status'          => 'required|string',
            'mata_kuliah_id'  => 'nullable|array',
        ]);

        // Validasi Batas SKS (Maksimal 24 SKS) pada saat Update
        if ($request->has('mata_kuliah_id')) {
            $totalSks = MataKuliah::whereIn('id', $request->mata_kuliah_id)->sum('sks');
            if ($totalSks > 24) {
                return back()->withErrors(['mata_kuliah_id' => 'Total SKS yang dipilih melebihi batas maksimum (24 SKS). Total SKS Anda: ' . $totalSks])->withInput();
            }
        }

        $krs = Krs::findOrFail($id);

        $krs->update([
            'mahasiswa_id'    => $request->mahasiswa_id,
            'tahun_akademik'  => $request->tahun_akademik,
            'semester'        => $request->semester,
            'status'          => $request->status,
        ]);

        if ($request->has('mata_kuliah_id')) {
            $krs->mataKuliah()->sync($request->mata_kuliah_id);
        } else {
            $krs->mataKuliah()->detach();
        }

        return redirect()->route('krs.index')->with('success', 'Data KRS berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $krs = Krs::findOrFail($id);
        $krs->mataKuliah()->detach();
        $krs->delete();

        return redirect()->route('krs.index')->with('success', 'Data KRS berhasil dihapus!');
    }
}