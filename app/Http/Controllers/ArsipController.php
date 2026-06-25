<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opd;
use App\Models\Arsip;
use App\Models\MasterKode;
use App\Models\Rak_arsip;
use App\Models\Dus_arsip;
use Illuminate\Support\Str;

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
        $data = Arsip::with([
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'masterKode:id,kode,nama',
            'user:id,name,email',
            'dus_arsip:id,nomor_dus,nomor_rak',
            'rak_arsip:id,nomor_rak'
        ])
        ->where('status', '!=', 'inaktif')
        ->latest()->get(); 

        return view('arsip.index', compact('data'
        ));
    }

    public function index_admin($opd_id = null)
    {
        $query= Arsip::with([
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'masterKode:id,kode,nama',
            'user:id,name,email',
            'dus_arsip:id,nomor_dus,nomor_rak',
            'rak_arsip:id,nomor_rak'
        ])
        ->where('status', '!=', 'inaktif');

            // JIKA ada parameter id_opd dikirim, lakukan filter arsip berdasarkan OPD tersebut
        if ($opd_id) {
            $query->where('opd_id', $opd_id); // Pastikan 'opd_id' adalah nama kolom foreign key di tabel arsip Anda
        }
        $data = $query->latest()->get(); 

        return view('arsip.index-admin', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function upload(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|max:50120'//+-50Mb
        ]);

        $file = $request->file('file');
        $filename = time().'_'.$file->getClientOriginalName();
        // dd($filename);

        $file->move(public_path('arsip'), $filename);

        $arsip = Arsip::findOrFail($id);
        $arsip->file = $filename;
        $arsip->save();

        return back()->with('success', 'File berhasil diupload');
    }
    public function uploads_post(Request $request)
    {
        $id=$request->input('id');
        $request->validate([
            'file' => 'required|file|max:50120'//+-50Mb
        ]);

        $file = $request->file('file');
        $filename = time().'_'.$file->getClientOriginalName();
        // dd($filename);

        $file->move(public_path('arsip'), $filename);

        $arsip = Arsip::findOrFail($id);
        $arsip->file = $filename;
        $arsip->save();

        return back()->with('success', 'File berhasil diupload');
    }

    public function search(Request $request)
    {
        $q = $request->q;
 
        $data = Arsip::with([
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi'
        ])
        ->where('judul', 'like', "%{$q}%")
        ->orWhere('nomor', 'like', "%{$q}%")
        ->orWhere('tanggal', 'like', "%{$q}%")
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
    public function create()
    {
        $opds = Opd::all();
        $data = Arsip::with([
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'masterKode:id,kode,nama',
            'user:id,name,email',
            'dus_arsip:id,nomor_dus,nomor_rak',
            'rak_arsip:id,nomor_rak'
        ])->latest()->get();  
        $masterKodes = MasterKode::all();
        $dus_arsips = Dus_arsip::all();
        $rak_arsips = rak_arsip::all();



        return view('arsip.create', compact(
            'data',
            'opds',
            'masterKodes',
            'dus_arsips',
            'rak_arsips'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    { 
        $filePath = null;
        try { 
            $data = Arsip::create([
                'korektor' => $request->korektor,
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'tanggal' => $request->tanggal,
                'master_kode_id' => $request->master_kode_id,
                'opd_id' => $request->opd_id,
                'retensi' => $request->retensi,
                'retensiinaktif' => $request->retensiinaktif,
                'nomor' => $request->nomor,
                'status' => $request->status ?? 'aktif',
                'pemusnahan' => $request->pemusnahan,
                'created_by' => auth()->id(),
                'file' => $filePath,
                
                // PERBAIKAN: Arahkan ke kolom ID baru yang ada di tabel arsips
                'dus_arsip_id' => $request->dus_arsip_id, // Pastikan nama input di HTML form Anda juga disesuaikan
                'rak_arsip_id' => $request->rak_arsip_id, // Pastikan nama input di HTML form Anda juga disesuaikan
            ]);
            
            return redirect()->route('arsip.home')
                ->with('success', 'Data berhasil ditambahkan!');  
        } catch (\Throwable $e) {
            dd($e->getMessage());
        } 
    } 

    public function uploads(Request $request){
        try{ 
            if ($request->hasFile('file')) {

                $file = $request->file('file');

                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

                // Bersihkan nama file
                $safeName = Str::slug($originalName);

                // Ambil ekstensi asli
                $extension = $file->getClientOriginalExtension();

                // Nama final
                $fileName = time() . '_' . $safeName . '.' . $extension;
                // echo $fileName;die();

                // $file->move(public_path('arsip'), $fileName);
                $filePath = $request->file('file')
                ->store('arsip', 'public');
                // dd($filePath);
            }
        }
        catch (\Throwable $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        dd($id);
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    { 
        $data = Arsip::with([
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'masterKode:id,kode,nama',
            'user:id,name,email',
            'dus_arsip:id,nomor_dus,nomor_rak',
            'rak_arsip:id,nomor_rak'
        ])->findOrFail($id);

        $opds = Opd::all();
        $masterKodes = MasterKode::all();

        return view('arsip.edit', compact('id',
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
            'nomor_dus' => $request->nomor_dus,
            'nomor_rak' => $request->nomor_rak, 
        ]);

        return redirect()->route('arsip.home')
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
