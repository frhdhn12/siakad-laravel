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
    /**
     * Menampilkan halaman index daftar dosen.
     */
    public function index(): View
    {
        return view('dosen.index');
    }

    /**
     * Menyediakan data JSON untuk DataTables.
     */
    public function data(): JsonResponse
    {
        $dosen = Dosen::select(['id', 'nidn', 'nama', 'email', 'telepon']);

        return DataTables::of($dosen)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $btn = '<a href="'.route('dosen.show', $row->id).'" class="btn btn-info btn-sm me-1">Detail</a>';
                $btn .= '<a href="'.route('dosen.edit', $row->id).'" class="btn btn-warning btn-sm me-1">Edit</a>';
                $btn .= '<button type="button" class="btn btn-danger btn-sm btn-hapus" data-url="'.route('dosen.destroy', $row->id).'" data-nama="'.$row->nama.'">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Menampilkan form tambah dosen.
     */
    public function create(): View
    {
        return view('dosen.create');
    }

    /**
     * Menyimpan data dosen baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        Dosen::create($this->validated($request));

        return redirect()
            ->route('dosen.index')
            ->with('success', 'Data dosen berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail data dosen.
     */
    public function show(Dosen $dosen): View
    {
        return view('dosen.show', compact('dosen'));
    }

    /**
     * Menampilkan form edit dosen.
     */
    public function edit(Dosen $dosen): View
    {
        return view('dosen.edit', compact('dosen'));
    }

    /**
     * Memperbarui data dosen di database.
     */
    public function update(Request $request, Dosen $dosen): RedirectResponse
    {
        $dosen->update($this->validated($request, $dosen));

        return redirect()
            ->route('dosen.index')
            ->with('success', 'Data dosen ' . $dosen->nama . ' berhasil diperbarui.');
    }

    /**
     * Menghapus data dosen.
     */
    public function destroy(Dosen $dosen): JsonResponse
    {
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

    /**
     * Aturan validasi bersama untuk store dan update.
     */
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