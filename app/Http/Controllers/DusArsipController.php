<?php

namespace App\Http\Controllers;

use App\Models\Dus_Arsip;
use App\Models\Rak_Arsip;
use App\Models\Opd;
use App\Models\Opd_Induk;
use App\Models\User;
use App\Models\Arsip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode; 
use Illuminate\Support\Facades\Storage;


class DusArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function qr_list_berkas($id){
        $dus = Dus_Arsip::findOrFail($id);
        $data = Arsip::where('dus_arsip_id',$id);
        return view('dus_arsip.qr_list_berkas', compact('data','dus'
        ));

    }
    public function generate_qr($id)
    {
        // 1. Ambil data dus berdasarkan ID
        $dus = Dus_Arsip::findOrFail($id);

        // 2. Tentukan isi/konten dari QR Code
        // (Bisa berupa URL, teks, atau kode unik dus) 
        $isiQrCode = 'https://satu.arpus.cilacapkab.go.id/dus_arsip/' . $id; 
        $fileName = 'qr-dus-' . $dus->nomor_dus . '-' . time() . '.svg';

        // 3. Generate QR Code menjadi format SVG/HTML
        $qr = QrCode::size(200)->margin(1)->generate($isiQrCode);
        // Simpan file tersebut ke folder: storage/app/public/qr-codes/
        Storage::disk('public')->put('qr-codes/' . $fileName, $qr);
        
        // Simpan path filenya ke database
        $dus->qrcode = 'qr-codes/' . $fileName;
        $dus->save();

        // 4. Return hasilnya dengan format HTML agar bisa ditangkap oleh Modal JS kita
        return response()->json([
            'html' => '
                <div class="text-center">
                    ' . $qr . '
                    <h6 class="mt-3 text-dark fw-bold">' . $dus->nama_dus . '</h6>
                </div>
            '
        ]);
    }
    public function index()
    {
        // Ambil data user yang sedang login beserta id OPD-nya
        $user = auth()->user(); 

        // Pastikan nama kolom 'opd_id' sesuai di tabel users
        $userOpdId = $user->opd_induk_id; 

        $data = Dus_Arsip::with([
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'opd_induk:id,instansi,kode_instansi',
            'rak_arsip:id,nomor_rak'
        ])
        ->where('opd_induk_id', $userOpdId)
        ->get(); 

        return view('dus_arsip.index', compact('data'
        ));
        //
    }
    public function search(Request $request){

        $q = $request->q;
 
        $data = Dus_Arsip::with([
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'rak_arsip:id,nomor_rak'
        ])
        ->where('nomor_rak', 'like', "%{$q}%")
        ->orWhere('opd_id', 'like', "%{$q}%")
        ->orWhereHas('rak_arsip', function ($query) use ($q) {
            $query->where('nomor_rak', 'like', "%{$q}%"); 
        })
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
    public function search2(Request $request){

        $q = $request->q;
 
        $data = Dus_Arsip::with([
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'rak_arsip:id,nomor_rak'
        ])
        ->where('nomor_dus', 'like', "%{$q}%")
        ->orWhere('opd_id', 'like', "%{$q}%")
        ->orWhereHas('rak_arsip', function ($query) use ($q) {
            $query->where('nomor_rak', 'like', "%{$q}%"); 
        })
        ->limit(20)
        ->get();

        return response()->json($data);
    }

    public function dashbord()
    {
        $data = Dus_Arsip::with([
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
        $user = auth()->user();
        
        // ambil id user untuk kode sementara
        $userid = auth()->id();
        // dd($userid);

        // Pastikan nama kolom 'opd_id' sesuai di tabel users
        $userOpdId = $user->opd_induk_id; 

        $opds = Opd::where('opd_induk_id', $userOpdId)->get();;

        return view('dus_arsip.create', compact(
            'opds' 
        )); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 
        try { 
            $data = Dus_Arsip::create([
                'rak_arsip_id' => $request->rak_arsip_id, 
                'nomor_dus' => $request->nomor_dus, 
                'opd_id' => $request->opd_id, 
                'opd_induk_id' => $request->opd_induk_id, 

            ]);
            return redirect()->route('dus_arsip.index')
                ->with('success', 'Data berhasil ditambahkan!');  
        } catch (\Throwable $e) {
            dd($e->getMessage());
        } 
    }

    /**
     * Display the specified resource.
     */
    public function show(Dus_arsip $dus_arsip)
    {
        //
    } 
    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Dus_arsip $dus_arsip)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find data by ID, will return 404 error if not found
            $dus = Dus_Arsip::findOrFail($id);
            
            // Delete data from database
            $dus->delete();
    
            return redirect()->route('dus_arsip.index')
                ->with('success', 'Data berhasil dihapus!');  
        } catch (\Throwable $e) {
            // Display error message if delete process fails
            dd($e->getMessage());
        }
    }
    public function edit($id)
    { 
        $data = Dus_Arsip::with([ 
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'rak_arsip:id,nomor_rak,opd_id'
        ])->findOrFail($id);

        $opds       = Opd::all(); 
        $rak_arsips = Rak_Arsip::with([ 
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi', 
        ])->get(); 

        return view('dus_arsip.edit', compact('id',
            'data',
            'rak_arsips',
            'opds' 
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    { 
        $arsip = Dus_Arsip::findOrFail($id); 
        $arsip->update([ 
                'nomor_dus' => $request->nomor_dus, 
                'nomor_rak' => $request->nomor_rak, 
                'opd_id' => $request->opd_id, 
        ]);

        return redirect()->route('dus_arsip.index')
            ->with('success', 'Data berhasil diupdate');
    }
}
