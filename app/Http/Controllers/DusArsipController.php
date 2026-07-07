<?php

namespace App\Http\Controllers;

use App\Models\Dus_arsip;
use App\Models\Rak_arsip;
use App\Models\Opd;
use App\Models\Opd_induk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DusArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data user yang sedang login beserta id OPD-nya
        $user = auth()->user(); 

        // Pastikan nama kolom 'opd_id' sesuai di tabel users
        $userOpdId = $user->opd_induk_id; 

        $data = Dus_arsip::with([
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'opd_induk:id,instansi,kode_instansi',
            'rak_arsip:id,nomor_rak'
        ])
        ->where('opd_induk_id', $userOpdId)
        ->get(); 

        return view('dus_arsip.index', compact('data'
        ));
        //
    }
    public function search(Request $request){

        $q = $request->q;
 
        $data = Dus_arsip::with([
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'rak_arsip:id,nomor_rak'
        ])
        ->where('nomor_rak', 'like', "%{$q}%")
        ->orWhere('opd_id', 'like', "%{$q}%")
        ->orWhereHas('rak_arsip', function ($query) use ($q) {
            $query->where('nomor_rak', 'like', "%{$q}%"); 
        })
        ->orWhereHas('opd', function ($query) use ($q) {
            $query->where('instansi', 'like', "%{$q}%")
                  ->orWhere('singkatan_instansi', 'like', "%{$q}%")
                  ->orWhere('unit_kerja', 'like', "%{$q}%")
                  ->orWhere('singkatan_uk', 'like', "%{$q}%");
        })
        ->limit(20)
        ->get();

        return response()->json($data);
    }
    public function dashbord()
    {
        $data = Dus_arsip::with([
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi'
        ])->latest()->get(); 

        return view('dus_arsip.index', compact('data'
        ));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $opds = Opd::all(); 

        return view('dus_arsip.create', compact(
            'opds' 
        )); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 
        try { 
            $data = Dus_arsip::create([
                'nomor_rak' => $request->nomor_rak, 
                'nomor_dus' => $request->nomor_dus, 
                'opd_id' => $request->opd_id, 
            ]);
            return redirect()->route('dus_arsip.index')
                ->with('success', 'Data berhasil ditambahkan!');  
        } catch (\Throwable $e) {
            dd($e->getMessage());
        } 
    }

    /**
     * Display the specified resource.
     */
    public function show(Dus_arsip $dus_arsip)
    {
        //
    } 
    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Dus_arsip $dus_arsip)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find data by ID, will return 404 error if not found
            $dus = Dus_arsip::findOrFail($id);
            
            // Delete data from database
            $dus->delete();
    
            return redirect()->route('dus_arsip.index')
                ->with('success', 'Data berhasil dihapus!');  
        } catch (\Throwable $e) {
            // Display error message if delete process fails
            dd($e->getMessage());
        }
    }
    public function edit($id)
    { 
        $data = Dus_arsip::with([ 
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'rak_arsip:id,nomor_rak,opd_id'
        ])->findOrFail($id);

        $opds       = Opd::all(); 
        $rak_arsips = Rak_arsip::with([ 
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi', 
        ])->latest()->get(); 

        return view('dus_arsip.edit', compact('id',
            'data',
            'rak_arsips',
            'opds' 
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    { 
        $arsip = Dus_arsip::findOrFail($id); 
        $arsip->update([ 
                'nomor_dus' => $request->nomor_dus, 
                'nomor_rak' => $request->nomor_rak, 
                'opd_id' => $request->opd_id, 
        ]);

        return redirect()->route('dus_arsip.index')
            ->with('success', 'Data berhasil diupdate');
    }
}
