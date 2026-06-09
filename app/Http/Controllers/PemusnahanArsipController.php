<?php

namespace App\Http\Controllers;

use App\Models\Pemusnahan_arsip;
use App\Models\Opd;
use App\Models\Arsip;
use Illuminate\Http\Request;

class PemusnahanArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Pemusnahan_arsip::with([
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'masterKode:id,kode,nama',
            'user:id,name,email'
        ])->latest()->get(); 

        return view('pemusnahan_arsip.index', compact('data'
        ));
        //
    }

    /**
     * Show the form for creating a new resource.
     */ 
    public function create()
    {
        // $opds = Opd::all();
        $arsip = Arsip::all();
        $data = Pemusnahan_arsip::with([
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'masterKode:id,kode,nama',
            'user:id,name,email',
            'dus_arsip:id,nomor_dus,nomor_rak',
            'rak_arsip:id,nomor_rak'
        ])->latest()->get();  
        // $masterKodes = MasterKode::all();

        return view('pemusnahan_arsip.create', compact(
            'data','arsip'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try { 
            $id_arsip=$request->input('id_arsip');  
            $data = Arsip::with([
                'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
                'masterKode:id,kode,nama',
                'user:id,name,email',
                'dus_arsip:id,nomor_dus,nomor_rak',
                'rak_arsip:id,nomor_rak'
            ])->findOrFail($id_arsip);
            if($data){

            }else{
                return redirect()->route('pemusnahan_arsip.create')
                ->with('error', 'wajib ada nomoor arsip!'); 
            }
            dd($request->all()); 
            $dataa = Pemusnahan_arsip::create([
                'id_arsip'  => $data->id,
                'pemusnahan'=> $request->tanggal_pemusnahan,
                'no_ba'     => $request->no_ba,
                'judul'     => $data->judul, 
                'deskripsi' => $data->deskripsi,
                'file'      => $data->file,
                'tanggal'   => $data->tanggal,
                'master_kode_id'=> $data->master_kode_id,
                'created_by'=> auth()->id(),
                'opd_id'    => $data->opd_id,
                'retensi'   => $data->retensi,
                'nomor'     => $data->nomor,
                'status'    => 'inaktif', 
                'korektor'  => $data->korektor, 
            ]);
            return redirect()->route('pemusnahan_arsip.home')
                ->with('success', 'Data berhasil ditambahkan!');  
        } catch (\Throwable $e) {
            return redirect()->route('pemusnahan_arsip.create')
            ->with('error', 'wajib ada nomoor arsip!'); 
            // dd($e->getMessage());
        } 
    }

    /**
     * Display the specified resource.
     */
    public function show(Pemusnahan_arsip $pemusnahan_arsip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pemusnahan_arsip $pemusnahan_arsip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pemusnahan_arsip $pemusnahan_arsip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemusnahan_arsip $pemusnahan_arsip)
    {
        //
    }
}
