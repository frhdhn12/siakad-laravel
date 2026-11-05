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
            $data = Mahasiswa::select(['id', 'nim', 'nama', 'angkatan', 'email']);
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('mahasiswa.show', $row->nim).'" class="btn btn-info btn-sm me-1">Detail</a>';
                    $btn .= '<a href="'.route('mahasiswa.edit', $row->nim).'" class="btn btn-warning btn-sm me-1">Edit</a>';
                    $btn .= '<form action="'.route('mahasiswa.destroy', $row->nim).'" method="POST" class="d-inline" onsubmit="return confirm(\'Yakin ingin menghapus data ini?\')">';
                    $btn .= csrf_field() . method_field('DELETE');
                    $btn .= '<button type="submit" class="btn btn-danger btn-sm">Hapus</button>';
                    $btn .= '</form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}