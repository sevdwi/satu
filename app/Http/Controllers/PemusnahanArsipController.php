<?php

namespace App\Http\Controllers;

use App\Models\Pemusnahan_arsip;
use App\Models\Opd;
use App\Models\Arsip;
use App\Models\MasterKode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
    public function uploadBA(Request $request)
    {
        try {
            // dd($request->all());

            $request->validate([
                'id' => 'required|exists:pemusnahan_arsips,id',
                'file_ba' => 'required|mimes:pdf|max:51200', // 50 MB
            ]);

            $data = Pemusnahan_arsip::findOrFail($request->id);

            $file = $request->file('file_ba');

            $originalName = pathinfo(
                $file->getClientOriginalName(),
                PATHINFO_FILENAME
            );

            $safeName = Str::slug($originalName);

            $extension = $file->getClientOriginalExtension();

            $fileName = time().'_'.$safeName.'.'.$extension;

            // simpan ke storage/app/public/ba_pemusnahan
            $filePath = $file->storeAs(
                'ba_pemusnahan',
                $fileName,
                'public'
            );

            // update database
            $data->update([
                'file_ba' => $filePath
            ]);

            return redirect()
                ->back()
                ->with('success', 'File BA berhasil diupload');

        } catch (\Throwable $e) {

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function uploadBAa(Request $request){ 
        try{ 
            if ($request->hasFile('file_ba')) {

                $file = $request->file('file_ba');

                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

                // Bersihkan nama file
                $safeName = Str::slug($originalName);

                // Ambil ekstensi asli
                $extension = $file->getClientOriginalExtension();

                // Nama final
                $fileName = time() . '_' . $safeName . '.' . $extension;
                // echo $fileName;die();

                // $file->move(public_path('arsip'), $fileName);
                $filePath = $request->file('file_ba')
                ->store('ba_pemusnahan', 'public');
                // dd($filePath);
            }
        }
        catch (\Throwable $e) {
            dd($e->getMessage());
        }
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
            DB::beginTransaction();
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
            // dd($request->all()); 
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

            // hapus arsip asli
            // $arsip->delete();
            $data->update([
                'status'    => 'inaktif',
                'pemusnahan'=> now()
            ]);

            DB::commit();
            return redirect()->route('pemusnahan_arsip.home')
                ->with('success', 'Data berhasil ditambahkan!');  
        } catch (\Throwable $e) {
            DB::rollBack();
            // return redirect()->route('pemusnahan_arsip.create')
            // ->with('error', 'wajib ada nomoor arsip!'); 
            dd($e->getMessage());
        } 
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {  
        $data = Pemusnahan_arsip::with([
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'masterKode:id,kode,nama',
            'user:id,name,email'
        ])->findOrFail($id); 

        $opds = Opd::all();
        $masterKodes = MasterKode::all();

        return view('pemusnahan_arsip.detil', compact('id',
            'data',
            'opds',
            'masterKodes'
        ));
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
