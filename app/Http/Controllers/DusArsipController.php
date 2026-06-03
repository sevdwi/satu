<?php

namespace App\Http\Controllers;

use App\Models\Dus_arsip;
use Illuminate\Http\Request;

class DusArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
    public function show(Dus_arsip $dus_arsip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dus_arsip $dus_arsip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dus_arsip $dus_arsip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dus_arsip $dus_arsip)
    {
        //
    }
}
