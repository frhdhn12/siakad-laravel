<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class DosenController extends Controller
{
    public function index(): View
    {
        return view('dosen.index');
    }

    public function data(): JsonResponse
    {
        $dosen = Dosen::select(['id', 'nidn', 'nama', 'email', 'telepon']);

        return DataTables::of($dosen)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                // Tombol Detail selalu tampil untuk semua role
                $btn  = '<a href="'.route('dosen.show', $row->id).'" class="btn btn-info btn-sm me-1 text-white" title="Detail"><i class="bi bi-eye"></i></a>';
                
                // Tombol Edit & Hapus hanya tampil jika role adalah admin
                if (auth()->check() && auth()->user()->role === 'admin') {
                    $btn .= '<a href="'.route('dosen.edit', $row->id).'" class="btn btn-warning btn-sm me-1 text-white" title="Edit"><i class="bi bi-pencil-square"></i></a>';
                    $btn .= '<button type="button" class="btn btn-danger btn-sm btn-hapus" data-id="'.$row->id.'" data-nama="'.e($row->nama).'" title="Hapus"><i class="bi bi-trash"></i></button>';
                }
                
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create(): View
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('dosen.create');
    }

    public function store(Request $request): RedirectResponse
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        Dosen::create($this->validated($request));

        return redirect()
            ->route('dosen.index')
            ->with('success', 'Data dosen berhasil ditambahkan.');
    }

    public function show(Dosen $dosen): View
    {
        return view('dosen.show', compact('dosen'));
    }

    public function edit(Dosen $dosen): View
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('dosen.edit', compact('dosen'));
    }

    public function update(Request $request, Dosen $dosen): RedirectResponse
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $dosen->update($this->validated($request, $dosen));

        return redirect()
            ->route('dosen.index')
            ->with('success', 'Data dosen ' . $dosen->nama . ' berhasil diperbarui.');
    }

    public function destroy(Dosen $dosen): JsonResponse
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        try {
            $dosen->delete();
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Data dosen tidak dapat dihapus: masih dipakai data lain.',
            ], 489);
        }

        return response()->json([
            'message' => 'Data dosen ' . $dosen->nama . ' berhasil dihapus.',
        ]);
    }

    private function validated(Request $request, ?Dosen $dosen = null): array
    {
        return $request->validate([
            'nidn' => [
                'required', 'string', 'max:20',
                Rule::unique(Dosen::class, 'nidn')->ignore($dosen?->id),
            ],
            'nama' => ['required', 'string', 'max:120'],
            'email' => [
                'required', 'email', 'max:120',
                Rule::unique(Dosen::class, 'email')->ignore($dosen?->id),
            ],
            'telepon' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:500'],
        ], [
            'nidn.required' => 'NIDN wajib diisi.',
            'nidn.max' => 'NIDN maksimal 20 karakter.',
            'nidn.unique' => 'NIDN sudah dipakai dosen lain.',
            'nama.required' => 'Nama dosen wajib diisi.',
            'nama.max' => 'Nama dosen maksimal 120 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 120 karakter.',
            'email.unique' => 'Email sudah dipakai dosen lain.',
            'telepon.max' => 'Nomor telepon maksimal 20 karakter.',
            'alamat.max' => 'Alamat maksimal 500 karakter.',
        ]);
    }
}