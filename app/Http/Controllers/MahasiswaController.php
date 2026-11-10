<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Mahasiswa;
use Yajra\DataTables\Facades\DataTables;

class MahasiswaController extends Controller
{
    public function index(): View
    {
        return view('mahasiswa.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = Mahasiswa::select(['id', 'nim', 'nama', 'jenis_kelamin', 'angkatan', 'program_studi', 'email']);
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    // Tombol Detail selalu tampil untuk semua role
                    $btn = '<a href="'.route('mahasiswa.show', $row->nim).'" class="btn btn-info btn-sm me-1 text-white" title="Detail"><i class="bi bi-eye"></i></a>';
                    
                    // Tombol Edit dan Hapus hanya tampil jika role pengakses adalah admin
                    if (auth()->check() && auth()->user()->role === 'admin') {
                        $btn .= '<a href="'.route('mahasiswa.edit', $row->nim).'" class="btn btn-warning btn-sm me-1 text-white" title="Edit"><i class="bi bi-pencil-square"></i></a>';
                        $btn .= '<form action="'.route('mahasiswa.destroy', $row->nim).'" method="POST" class="d-inline form-delete">';
                        $btn .= csrf_field();
                        $btn .= method_field('DELETE');
                        $btn .= '<button type="button" class="btn btn-danger btn-sm btn-delete" title="Hapus" data-nama="'.e($row->nama).'"><i class="bi bi-trash"></i></button>';
                        $btn .= '</form>';
                    }
                    
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        // Otorisasi Server-Side: Tolak akses jika bukan admin (Error 403)
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki hak akses untuk menambahkan data mahasiswa.');
        }

        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        // Otorisasi Server-Side: Tolak akses jika bukan admin (Error 403)
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki hak akses untuk menyimpan data mahasiswa.');
        }

        $request->validate([
            'nim' => 'required|unique:mahasiswa,nim',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'angkatan' => 'required',
            'program_studi' => 'required',
            'email' => 'required|email',
        ]);

        Mahasiswa::create($request->all());
        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function show($nim)
    {
        $mahasiswa = Mahasiswa::where('nim', $nim)->firstOrFail();
        return view('mahasiswa.show', compact('mahasiswa'));
    }

    public function edit($nim)
    {
        // Otorisasi Server-Side: Tolak akses jika bukan admin (Error 403)
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah data mahasiswa.');
        }

        $mahasiswa = Mahasiswa::where('nim', $nim)->firstOrFail();
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, $nim)
    {
        // Otorisasi Server-Side: Tolak akses jika bukan admin (Error 403)
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki hak akses untuk memperbarui data mahasiswa.');
        }

        $mahasiswa = Mahasiswa::where('nim', $nim)->firstOrFail();
        
        $request->validate([
            'nim' => 'required|unique:mahasiswa,nim,' . $mahasiswa->id,
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'angkatan' => 'required',
            'program_studi' => 'required',
            'email' => 'required|email',
        ]);

        $mahasiswa->update($request->all());
        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diupdate.');
    }

    public function destroy($nim)
    {
        // Otorisasi Server-Side: Tolak akses jika bukan admin (Error 403)
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus data mahasiswa.');
        }

        $mahasiswa = Mahasiswa::where('nim', $nim)->firstOrFail();
        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}