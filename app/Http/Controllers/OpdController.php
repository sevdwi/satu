<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\Opd_Induk;
use Illuminate\Http\Request;

class OpdController extends Controller
{
    public function index($opd_induk_id)
    {
        $opd_induk = Opd_induk::findOrFail($opd_induk_id);
        $data_opd = Opd::with([
            'opd_induk:id,instansi'
        ])
        ->where('opd_induk_id', $opd_induk_id) // Menyaring berdasarkan OPD Induk
        ->latest()
        ->get();

        return view('opd.index', compact('data_opd'));
    }


    public function create()
    {
        return view('opd.create');
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
        $request->validate([
            'kode' => 'required|unique:opds',
            'nama' => 'required'
        ]);

        Opd::create($request->all());

        return redirect()->route('opd.index')
            ->with('success', 'OPD berhasil ditambahkan');
    }

    public function edit($id)
    {
        $opd = Opd::findOrFail($id);
        return view('opd.edit', compact('opd'));
    }

    public function update(Request $request, $id)
    {
        $opd = Opd::findOrFail($id);

        $request->validate([
            'kode' => 'required|unique:opds,kode,' . $id,
            'nama' => 'required'
        ]);

        $opd->update($request->all());

        return redirect()->route('opd.index')
            ->with('success', 'OPD berhasil diupdate');
    }

    public function destroy($id)
    {
        Opd::findOrFail($id)->delete();

        return back()->with('success', 'OPD berhasil dihapus');
    }
}