<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\MataKuliah;
use Yajra\DataTables\Facades\DataTables;

class MataKuliahController extends Controller
{
    public function index(): View
    {
        return view('matakuliah.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = MataKuliah::select(['id', 'kode_mk', 'nama_mk', 'sks']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    // Tombol Detail selalu tampil untuk semua role
                    $btn = '<a href="'.route('matakuliah.show', $row->kode_mk).'" class="btn btn-info btn-sm me-1 text-white" title="Detail"><i class="bi bi-eye"></i></a>';
                    
                    // Tombol Edit dan Hapus hanya tampil jika role pengakses adalah admin
                    if (auth()->check() && auth()->user()->role === 'admin') {
                        $btn .= '<a href="'.route('matakuliah.edit', $row->kode_mk).'" class="btn btn-warning btn-sm me-1 text-white" title="Edit"><i class="bi bi-pencil-square"></i></a>';
                        $btn .= '<form action="'.route('matakuliah.destroy', $row->kode_mk).'" method="POST" class="d-inline form-delete">';
                        $btn .= csrf_field();
                        $btn .= method_field('DELETE');
                        $btn .= '<button type="button" class="btn btn-danger btn-sm btn-delete" title="Hapus" data-nama="'.e($row->nama_mk).'"><i class="bi bi-trash"></i></button>';
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
            abort(403, 'Anda tidak memiliki hak akses untuk menambahkan data mata kuliah.');
        }

        return view('matakuliah.create');
    }

    public function store(Request $request)
    {
        // Otorisasi Server-Side: Tolak akses jika bukan admin (Error 403)
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki hak akses untuk menyimpan data mata kuliah.');
        }

        $request->validate([
            'kode_mk' => 'required|unique:mata_kuliah,kode_mk',
            'nama_mk' => 'required',
            'sks' => 'required|numeric',
        ]);

        MataKuliah::create($request->all());
        return redirect()->route('matakuliah.index')->with('success', 'Data mata kuliah berhasil ditambahkan.');
    }

    public function show($kode_mk)
    {
        $mataKuliah = MataKuliah::where('kode_mk', $kode_mk)->firstOrFail();
        return view('matakuliah.show', compact('mataKuliah'));
    }

    public function edit($kode_mk)
    {
        // Otorisasi Server-Side: Tolak akses jika bukan admin (Error 403)
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah data mata kuliah.');
        }

        $mataKuliah = MataKuliah::where('kode_mk', $kode_mk)->firstOrFail();
        return view('matakuliah.edit', compact('mataKuliah'));
    }

    public function update(Request $request, $kode_mk)
    {
        // Otorisasi Server-Side: Tolak akses jika bukan admin (Error 403)
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki hak akses untuk memperbarui data mata kuliah.');
        }

        $mataKuliah = MataKuliah::where('kode_mk', $kode_mk)->firstOrFail();
        
        $request->validate([
            'kode_mk' => 'required|unique:mata_kuliah,kode_mk,' . $mataKuliah->id,
            'nama_mk' => 'required',
            'sks' => 'required|numeric',
        ]);

        $mataKuliah->update($request->all());
        return redirect()->route('matakuliah.index')->with('success', 'Data mata kuliah berhasil diupdate.');
    }

    public function destroy($kode_mk)
    {
        // Otorisasi Server-Side: Tolak akses jika bukan admin (Error 403)
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus data mata kuliah.');
        }

        $mataKuliah = MataKuliah::where('kode_mk', $kode_mk)->firstOrFail();
        $mataKuliah->delete();
        return redirect()->route('matakuliah.index')->with('success', 'Data mata kuliah berhasil dihapus.');
    }
}