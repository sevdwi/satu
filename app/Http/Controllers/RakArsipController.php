<?php

namespace App\Http\Controllers;

use App\Models\Rak_arsip;
use Illuminate\Http\Request;

class RakArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Rak_arsip::with([
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi'
        ])->latest()->get(); 

        return view('rak_arsip.index', compact('data'
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
    public function show(Rak_arsip $rak_arsip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rak_arsip $rak_arsip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rak_arsip $rak_arsip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rak_arsip $rak_arsip)
    {
        //
    }
}
