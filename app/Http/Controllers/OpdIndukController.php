<?php

namespace App\Http\Controllers;

use App\Models\Opd_Induk;
use App\Models\Opd;
use Illuminate\Http\Request;

class OpdIndukController extends Controller
{
    public function index()
    {
        $opd_induk = Opd_Induk::all();
        return view('opd_induk.index', compact('opd_induk'));
    }

    
    public function search(Request $request)
    {
        $q = $request->q;
 
        $data = Opd_Induk::where('instansi', 'like', "%$q%")
            ->orWhere('kode_instansi', 'like', "%$q%")
            // ->orWhere('singkatan_instansi', 'like', "%$q%")
            ->limit(20)
            ->get();

        return response()->json($data);
    }

    public function create()
    {
        $opds = Opd::orderBy('instansi')->get(); // sesuaikan nama kolom
        $opd_induks = Opd_Induk::all();
        return view('opd_induk.create', compact('opds','opd_induks'));
    }

    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $validatedData = $request->validate([
            'kode_instansi'      => 'required|string|max:255',
            'instansi'           => 'required|string|max:255',
            'singkatan_instansi' => 'required|string|max:255',
        ], [
            // Kustomisasi pesan error (Opsional)
            'kode_instansi.required' => 'Kode instansi wajib diisi.',
            'instansi.required'      => 'Nama instansi wajib diisi.',
        ]);

        // 2. Simpan data ke database menggunakan Mass Assignment
        // Ganti 'OpdInduk' dengan nama Model yang Anda gunakan untuk tabel ini
        Opd_Induk::create([
            'kode_instansi'      => $validatedData['kode_instansi'],
            'instansi'           => $validatedData['instansi'],
            'singkatan_instansi' => $validatedData['singkatan_instansi'],
        ]);

        // 3. Alihkan halaman kembali dengan pesan sukses
        return redirect()->route('opd_induk.index')->with('success', 'Data instansi berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        try {
            // Find data by ID, will return 404 error if not found
            $opd_induk = Opd_Induk::findOrFail($id);
            
            // Delete data from database
            $opd_induk->delete();
    
            return redirect()->route('opd_induk.index')
                ->with('success', 'Data berhasil dihapus!');  
        } catch (\Throwable $e) {
            // Display error message if delete process fails
            dd($e->getMessage());
        }
    }

    // form edit
    public function edit($id)
    {
        // 1. Cari data berdasarkan ID, jika tidak ketemu akan otomatis error 404
        $opd_induk = Opd_Induk::findOrFail($id);
    
        // 2. Tampilkan view edit dan kirimkan data yang akan diedit
        // Ganti 'arsip.edit' sesuai dengan folder dan nama file blade form edit Anda
        return view('opd_induk.edit', compact('opd_induk'));
    }
    

    public function update(Request $request, $id)
    {
        // 1. Validasi input dari form edit
        $validatedData = $request->validate([
            'kode_instansi'      => 'required|string|max:255',
            'instansi'           => 'required|string|max:255',
            'singkatan_instansi' => 'required|string|max:255',
        ], [
            // Kustomisasi pesan error (Opsional)
            'kode_instansi.required' => 'Kode instansi wajib diisi.',
            'instansi.required'      => 'Nama instansi wajib diisi.',
            'singkatan_instansi.required' => 'Singkatan instansi wajib diisi.',
        ]);

        // 2. Cari data lama berdasarkan ID
        $opdInduk = Opd_Induk::findOrFail($id);

        // 3. Perbarui data di database menggunakan Mass Assignment
        $opdInduk->update([
            'kode_instansi'      => $validatedData['kode_instansi'],
            'instansi'           => $validatedData['instansi'],
            'singkatan_instansi' => $validatedData['singkatan_instansi'],
        ]);

        // 4. Alihkan halaman kembali dengan pesan sukses
        return redirect()->route('opd_induk.index')->with('success', 'Data berhasil diupdate');
    }

    


}
