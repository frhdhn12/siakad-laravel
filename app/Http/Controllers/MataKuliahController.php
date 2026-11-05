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
                    $btn = '<a href="'.route('matakuliah.show', $row->kode_mk).'" class="btn btn-info btn-sm me-1">Detail</a>';
                    $btn .= '<a href="'.route('matakuliah.edit', $row->kode_mk).'" class="btn btn-warning btn-sm me-1">Edit</a>';
                    $btn .= '<form action="'.route('matakuliah.destroy', $row->kode_mk).'" method="POST" class="d-inline" onsubmit="return confirm(\'Yakin ingin menghapus data ini?\')">';
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