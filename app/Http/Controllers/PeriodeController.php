<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\Opd;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        // Ambil data user yang sedang login beserta id OPD-nya
        $user = auth()->user(); 
        // $userUnit = $user->opd_id;


        // Mengambil semua data periode beserta nama OPD-nya
        $data_filter = Periode::with([
            'opd:id,unit_kerja' // WAJIB sertakan id tabel induk agar bisa dicocokkan dengan opd_id
        ]);
        if ($user->opd && strtolower($user->opd->unit_kerja) !== 'sekretariat') {
            $data_filter->where('opd_id', $user->opd_id); 
        }        
        $periodes = $data_filter->latest('id')->get();    

    
        return view('periode.index', compact('periodes'));
    }

    public function create()
    {
        // $opds = Opd::orderBy('instansi')->get(); // sesuaikan nama kolom
        // $opd_induks = Opd_Induk::all();
        $opds = Opd::all();
        return view('periode.create', compact('opds'));
    }

    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $validatedData = $request->validate([
        'tahun'  => 'required|integer|digits:4',
        'tahap'  => 'required|in:1,2,3,4',
        'status' => 'required|in:buka,tutup',
        ], [
            // Kustomisasi pesan error (Opsional)
            'tahun' => 'Kode instansi wajib diisi.',
            'tahap'      => 'Nama instansi wajib diisi.',
            'status'      => 'Nama instansi wajib diisi.',
        ]);

        // 2. Simpan data ke database menggunakan Mass Assignment
        // Ganti 'OpdInduk' dengan nama Model yang Anda gunakan untuk tabel ini
        Periode::create([
            'opd_id' => $request->opd_id,
            'tahun'      => $validatedData['kode_instansi'],
            'tahap'           => $validatedData['instansi'],
            'status' => $validatedData['singkatan_instansi'],
        ]);

        // 3. Alihkan halaman kembali dengan pesan sukses
        return redirect()->route('periode.index')->with('success', 'Data instansi berhasil ditambahkan!');
    }

    public function edit($opd_id)
    {
        // $periodes = Periode::findOrFail($opd_id);
        $data_periode = Periode::with([
            'opd:id,unit_kerja,instansi'
        ])
        ->where('opd_id', $opd_id) // Menyaring berdasarkan Unit kerja
        ->latest('id')
        ->first(); // Mengambil satu data terbaru sebagai objek tunggal;
        // dd($data_periode);
            // Jaga-jaga jika data periode untuk OPD tersebut belum ada sama sekali
        if (!$data_periode) {
            abort(404, 'Data periode untuk OPD ini belum dibuat.');
        }

        return view('periode.edit', compact('data_periode'));
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi input dari form edit
        $validatedData = $request->validate([
        'tahun'  => 'required|integer|digits:4',
        'tahap'  => 'required|in:1,2,3,4',
        'status' => 'required|in:buka,tutup',
        ], [
            // Kustomisasi pesan error (Opsional)
            'tahun' => 'Kode instansi wajib diisi.',
            'tahap'      => 'Nama instansi wajib diisi.',
            'status'      => 'Nama instansi wajib diisi.',
        ]);

        // 2. Cari data lama berdasarkan ID
        $periode = Periode::findOrFail($id);

        // 3. Perbarui data di database menggunakan Mass Assignment
        $periode->update([
            'opd_id' => $request->opd_id,
            'tahun' => $validatedData['tahun'],
            'tahap'      => $validatedData['tahap'],
            'status'      => $validatedData['status'],
        ]);

        // 4. Alihkan halaman kembali dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Data berhasil diupdate');
    }



    public function destroy($id)
    {
        Periode::findOrFail($id)->delete();

        return back()->with('success', 'tahap berhasil dihapus');
    }



    
}
