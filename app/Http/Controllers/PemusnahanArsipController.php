<?php

namespace App\Http\Controllers;

use App\Models\Pemusnahan_arsip;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
