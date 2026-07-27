<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\Opd_Induk;
use Illuminate\Http\Request;

class OpdController extends Controller
{
    public function index($opd_induk_id)
    {
        $opd_induk = Opd_Induk::findOrFail($opd_induk_id);
        $data_opd = Opd::with([
            'opd_induk:id,instansi'
        ])
        ->where('opd_induk_id', $opd_induk_id) // Menyaring berdasarkan OPD Induk
        ->latest()
        ->get();

        return view('opd.index', compact('data_opd','opd_induk'));
    }


    public function create($opd_induk_id)
    {
        $opd_induk = Opd_Induk::findOrFail($opd_induk_id);
        return view('opd.create',compact('opd_induk'));
    }
    public function search(Request $request)
    {
        $q = $request->q;
 
        $data = Opd::where('unit_kerja', 'like', "%$q%")
            ->orWhere('kode_instansi', 'like', "%$q%")
            ->orWhere('singkatan_uk', 'like', "%$q%")
            ->orWhere('instansi', 'like', "%$q%")
            ->orWhere('singkatan_instansi', 'like', "%$q%")
            ->limit(20)
            ->get();

        return response()->json($data);
    }
    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $validatedData = $request->validate([
            'kode_instansi'      => 'required|string|max:255',
            'unit_kerja'           => 'required|string|max:255',
            'singkatan_uk' => 'required|string|max:255',
            'instansi'           => 'required|string|max:255',
            // 'singkatan_instansi' => 'required|string|max:255',
        ], [
            // Kustomisasi pesan error (Opsional)
            'kode_instansi.required' => 'Kode instansi wajib diisi.',
            'unit_kerja.required'      => 'unit kerja wajib diisi.',
            'singkatan_uk.required'      => 'singkatan unit kerja wajib diisi.',

        ]);

        // 2. Simpan data ke database menggunakan Mass Assignment
        Opd::create([
            'kode_instansi'      => $validatedData['kode_instansi'],
            'unit_kerja'           => $validatedData['unit_kerja'],
            'singkatan_uk' => $validatedData['singkatan_uk'],
            'instansi'           => $validatedData['instansi'],
            // 'singkatan_instansi' => $validatedData['singkatan_instansi'],
            'opd_induk_id' => $request->opd_induk_id,


        ]);

        // 3. Alihkan halaman kembali dengan pesan sukses
        return redirect()->route('opd_induk.index')->with('success', 'Data instansi berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $opd = Opd::findOrFail($id);
        return view('opd.edit', compact('opd'));
    }

    public function update(Request $request, $id)
    {
    // 1. Validasi input dari form
    $validatedData = $request->validate([
        'kode_instansi'      => 'required|string|max:255',
        'unit_kerja'         => 'required|string|max:255',
        'singkatan_uk'       => 'required|string|max:255',
        // 'instansi'           => 'required|string|max:255',
        // 'singkatan_instansi' => 'required|string|max:255',
    ], [
        // Kustomisasi pesan error (Opsional)
        'kode_instansi.required' => 'Kode instansi wajib diisi.',
        'unit_kerja.required'    => 'unit kerja wajib diisi.',
        'singkatan_uk.required'  => 'singkatan unit kerja wajib diisi.',
    ]);

    // 2. Cari data berdasarkan ID dan perbarui menggunakan Mass Assignment
    $opd = Opd::findOrFail($id);
    $opd->update([
        'kode_instansi'      => $validatedData['kode_instansi'],
        'unit_kerja'         => $validatedData['unit_kerja'],
        'singkatan_uk'       => $validatedData['singkatan_uk'],
        // 'instansi'           => $validatedData['instansi'],
        // 'singkatan_instansi' => $validatedData['singkatan_instansi'],
        // 'opd_induk_id'       => $request->opd_induk_id,
    ]);

    // 3. Alihkan halaman kembali dengan pesan sukses
    return redirect()->route('opd_induk.index')->with('success', 'Data instansi berhasil diperbarui!');
    }


    public function destroy($id)
    {
        Opd::findOrFail($id)->delete();

        return back()->with('success', 'OPD berhasil dihapus');
    }
}