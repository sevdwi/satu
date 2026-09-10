<?php

namespace App\Http\Controllers;

use App\Models\Rak_Arsip;
use App\Models\Opd;
use App\Models\Opd_Induk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RakArsipController extends Controller
{
    public function index()
    {
        // Ambil data user yang sedang login beserta id OPD-nya
        $user = auth()->user(); 

        // Pastikan nama kolom 'opd_id' sesuai di tabel users
        $userOpdId = $user->opd_induk_id; 
        
        $data = Rak_Arsip::with([
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'opd_induk:id,instansi,kode_instansi'
        ])
        ->where('opd_induk_id', $userOpdId)
        ->get(); 

        return view('rak_arsip.index', compact('data'
        ));
        //
    }

    public function search(Request $request){

        $q = $request->q;
 
        $data = Rak_Arsip::with([
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi'
        ])
        ->where(function ($query) use ($q) {
            $query->where('nomor_rak', 'like', "%{$q}%")
                  ->orWhere('opd_id', 'like', "%{$q}%")
                  ->orWhereHas('opd', function ($sub) use ($q) {
                      $sub->where('instansi', 'like', "%{$q}%")
                          ->orWhere('singkatan_instansi', 'like', "%{$q}%")
                          ->orWhere('unit_kerja', 'like', "%{$q}%")
                          ->orWhere('singkatan_uk', 'like', "%{$q}%");
                  });
        })
        ->where('opd_induk_id', auth()->user()->opd_induk_id)
        ->limit(20)
        ->get();

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userOpdId = auth()->user()->opd_induk_id;

        $opds = Opd::where('opd_induk_id', $userOpdId)->get();

        return view('rak_arsip.create', compact(
            'opds'
        ));
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  
        try { 
            Rak_Arsip::create([
                'nomor_rak' => $request->nomor_rak, 
                'opd_id' => $request->opd_id, 
                'opd_induk_id' => $request->opd_induk_id, 
            ]);
            return redirect()->route('rak_arsip.index')
                ->with('success', 'Data berhasil ditambahkan!');  
        } catch (\Throwable $e) {
            return redirect()->route('rak_arsip.index')
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        } 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    { 
        $data = Rak_Arsip::with([ 
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi'
        ])
        ->where('opd_induk_id', auth()->user()->opd_induk_id)
        ->findOrFail($id);

        $opds = Opd::all(); 

        return view('rak_arsip.edit', compact('id',
            'data',
            'opds' 
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    { 
        $arsip = Rak_Arsip::where('opd_induk_id', auth()->user()->opd_induk_id)
            ->findOrFail($id); 
        $arsip->update([ 
                'nomor_rak' => $request->nomor_rak, 
                'opd_id' => $request->opd_id, 
        ]);

        return redirect()->route('rak_arsip.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $rak = Rak_Arsip::where('opd_induk_id', auth()->user()->opd_induk_id)
                ->findOrFail($id);
            
            $rak->delete();
    
            return redirect()->route('rak_arsip.index')
                ->with('success', 'Data berhasil dihapus!');  
        } catch (\Throwable $e) {
            return redirect()->route('rak_arsip.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }

    }
}
