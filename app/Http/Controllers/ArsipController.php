<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opd;
use App\Models\Arsip;
use App\Models\MasterKode;

class ArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashbord(){

        // contoh data dari database
        $dataKategori = MasterKode::get();

        // warna bootstrap
        $warna = [
            '#0d6efd',
            '#198754',
            '#ffc107',
            '#dc3545',
            '#6f42c1',
            '#20c997',
            '#fd7e14',
            '#6610f2'
        ];

        // icon bootstrap
        $icons = [
            'bi-folder-fill',
            'bi-file-earmark-text-fill',
            'bi-archive-fill',
            'bi-journal-bookmark-fill',
            'bi-file-earmark-bar-graph-fill',
            'bi-collection-fill',
            'bi-folder2-open',
            'bi-files'
        ];

        $kategori = [];
        $chartLabels = [];
        $chartData = [];
        $chartColors = [];

        foreach ($dataKategori as $index => $item) {

            $color = $warna[$index % count($warna)];
            $icon = $icons[$index % count($icons)];

            $kategori[] = [
                'nama' => $item->nama,
                'total' => $item->arsip_count,
                'color' => $color,
                'icon' => $icon
            ];

            $chartLabels[] = $item->nama_kategori;
            $chartData[] = $item->arsip_count;
            $chartColors[] = $color;
        }

        return view('dashbord', compact(
            'kategori',
            'chartLabels',
            'chartData',
            'chartColors'
        ));
    } 
    public function index()
    {
        $data = Arsip::all();
        $opds = Opd::all();
        $masterKodes = MasterKode::all();

        return view('arsip.index', compact(
            'opds',
            'masterKodes','data'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $opds = Opd::all();
        $masterKodes = MasterKode::all();

        return view('arsip.create', compact(
            'opds',
            'masterKodes'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'judul' => 'required',
        ]);

        $fileName = null;

        if ($request->file('file')) {
            $fileName = time().'_'.$request->file('file')->getClientOriginalName();
            $request->file('file')->move(public_path('arsip'), $fileName);
        }

        Arsip::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'master_kode_id' => $request->master_kode_id,
            'opd_id' => $request->opd_id,
            'retensi' => $request->retensi,
            'nomor' => $request->nomor,
            'status' => $request->status ?? 'aktif',
            'pemusnahan' => $request->pemusnahan,
            'created_by' => auth()->id(),
            'file' => $fileName,
        ]);

        return redirect()->route('arsip.index')
            ->with('success', 'Data berhasil disimpan');
    } 

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Arsip::findOrFail($id);

        $opds = Opd::all();
        $masterKodes = MasterKode::all();

        return view('arsip.edit', compact(
            'data',
            'opds',
            'masterKodes'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $arsip = Arsip::findOrFail($id);

        $fileName = $arsip->file;

        if ($request->file('file')) {
            $fileName = time().'_'.$request->file('file')->getClientOriginalName();
            $request->file('file')->move(public_path('arsip'), $fileName);
        }

        $arsip->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'master_kode_id' => $request->master_kode_id,
            'opd_id' => $request->opd_id,
            'retensi' => $request->retensi,
            'nomor' => $request->nomor,
            'status' => $request->status,
            'pemusnahan' => $request->pemusnahan,
            'file' => $fileName,
        ]);

        return redirect()->route('arsip.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
