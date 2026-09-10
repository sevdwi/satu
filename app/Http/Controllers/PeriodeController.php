<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\Opd;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $user = auth()->user(); 

        $data_filter = Periode::with([
            'opd:id,unit_kerja' // WAJIB sertakan id tabel induk agar bisa dicocokkan dengan opd_id
        ]);
        if ($user->opd && strtolower($user->opd->unit_kerja) !== 'sekretariat') {
            $data_filter->where('opd_id', $user->opd_id); 
        }        
        $periodes = $data_filter->latest('id')->get();   
        
        $periodeBelum = Periode::where('opd_id', $user->opd_id)->count();
                
        return view('periode.index', compact('periodes','periodeBelum'));
    }

    public function create()
    {
        $opds = Opd::all();
        return view('periode.create', compact('opds'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'opd_id' => 'required|exists:opds,id',
            'tahun'  => 'required|integer|digits:4',
            'tahap'  => 'required|in:1,2,3,4',
            'status' => 'required|in:buka,tutup',
        ], [
            'opd_id.required' => 'Unit kerja wajib dipilih.',
            'tahun.required' => 'Tahun wajib diisi.',
            'tahap.required' => 'Tahap wajib diisi.',
            'status.required' => 'Status wajib diisi.',
        ]);

        Periode::create([
            'opd_id' => $validatedData['opd_id'],
            'tahun'  => $validatedData['tahun'],
            'tahap'  => $validatedData['tahap'],
            'status' => $validatedData['status'],
        ]);

        return redirect()->route('periode.index')->with('success', 'Data periode berhasil ditambahkan!');
    }

    public function edit($opd_id)
    {
        $data_periode = Periode::with([
            'opd:id,unit_kerja,instansi'
        ])
        ->where('opd_id', $opd_id)
        ->latest('id')
        ->first();

        if (!$data_periode) {
            abort(404, 'Data periode untuk OPD ini belum dibuat.');
        }

        return view('periode.edit', compact('data_periode'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'opd_id' => 'required|exists:opds,id',
            'tahun'  => 'required|integer|digits:4',
            'tahap'  => 'required|in:1,2,3,4',
            'status' => 'required|in:buka,tutup',
        ], [
            'opd_id.required' => 'Unit kerja wajib dipilih.',
            'tahun.required' => 'Tahun wajib diisi.',
            'tahap.required' => 'Tahap wajib diisi.',
            'status.required' => 'Status wajib diisi.',
        ]);

        $periode = Periode::findOrFail($id);

        $periode->update([
            'opd_id' => $validatedData['opd_id'],
            'tahun'  => $validatedData['tahun'],
            'tahap'  => $validatedData['tahap'],
            'status' => $validatedData['status'],
        ]);

        return redirect()->route('periode.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Periode::findOrFail($id)->delete();

        return back()->with('success', 'tahap berhasil dihapus');
    }
}
