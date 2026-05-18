<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use Illuminate\Http\Request;

class OpdController extends Controller
{
    public function index()
    {
        $data = Opd::latest()->get();
        return view('opd.index', compact('data'));
    }

    public function create()
    {
        return view('opd.create');
    }
    public function search2(Request $request)
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
        $data = Opd::findOrFail($id);
        return view('opd.edit', compact('data'));
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