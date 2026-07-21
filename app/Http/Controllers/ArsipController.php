<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Opd;
use App\Models\Opd_Induk;
use App\Models\Arsip;
use App\Models\MasterKode;
use App\Models\Rak_Arsip;
use App\Models\Dus_Arsip;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


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
        // Ambil data user yang sedang login beserta id OPD-nya
        // $user = auth()->user(); 
        $user = auth()->user()->opd; // load('opd'); 
        
        // ambil id user untuk kode sementara
        $userid = auth()->id();
        // dd($userid);

        // Pastikan nama kolom 'opd_id' sesuai di tabel users
        $userOpdId = $user->opd_induk_id; 
               
        $data_filter = Arsip::with([
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'masterKode:id,kode,nama',
            'user:id,name,email',
            'dus_arsip:id,nomor_dus',
            'rak_arsip:id,nomor_rak'
        ])
        ->where('opd_induk_id', $userOpdId) // Pastikan nama kolom 'opd_induk_id' ini ada di tabel arsips
        ->where('status', '!=', 'inaktif');
        // Cek kondisi Unit Kerja user
        // Jika BUKAN sekretariat, batasi arsip hanya untuk bidang milik user tersebut
        if ($user->opd && strtolower($user->opd->unit_kerja) !== 'sekretariat') {
            $data_filter->where('opd_id', $user->opd_id); 
        }
            // Eksekusi data
        $data = $data_filter->latest()->get(); 
        
        // ->latest()->get(); 

        return view('arsip.index', compact('data','userid'
        ));
    }

    public function index_admin()
    {
        $user = Auth::guard('admin')->user(); // Mengambil data dari provider 'users'

        $opd_induk = Opd_Induk::orderBy('instansi')->get(); // sesuaikan nama kolom


        $data = Arsip::with([
            'opd:id,kode_instansi,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'opd_induk:id,instansi',
            'masterKode:id,kode,nama',
            'user:id,name,email',
            'dus_arsip:id,nomor_dus',
            'rak_arsip:id,nomor_rak'
        ])
        ->where('status', '!=', 'inaktif')
        ->latest()->get(); 

        return view('arsip.index-admin', compact('user', 'data','opd_induk'));
    }


    public function detail_admin($opd_induk_id)
    {        
                // 1. Ambil data OPD Induk yang dipilih untuk menampilkan judul halaman
        $opd_induk = Opd_Induk::findOrFail($opd_induk_id);

        // 2. Ambil data arsip yang HANYA memiliki opd_induk_id sesuai tombol yang diklik
        $data_arsip = Arsip::with([
            'opd:id,kode_instansi,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'opd_induk:id,instansi',
            'masterKode:id,kode,nama',
            'user:id,name,email',
            'dus_arsip:id,nomor_dus',
            'rak_arsip:id,nomor_rak'
        ])
        ->where('opd_induk_id', $opd_induk_id) // Menyaring berdasarkan OPD Induk
        ->where('status', '!=', 'inaktif')
        ->latest()
        ->get();

        // 3. Kirim data ke halaman view baru (misal: arsip/detail-admin.blade.php)
        return view('arsip.detail-admin', compact('opd_induk', 'data_arsip'));
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
            'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'opd_induk:id,instansi'
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
        // Ambil data user yang sedang login beserta id OPD-nya
        $user = auth()->user(); 

        // Pastikan nama kolom 'opd_induk_id' sesuai di tabel users
        $userOpdId = $user->opd_induk_id; 

        $userUnit = $user->opd_id;
       
        // Filter OPD agar HANYA menampilkan OPD si user saja
        $opds = Opd::where('id', $userUnit)->get();

        $data = Arsip::with([
            'opd:id,opd_induk_id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'masterKode:id,kode,nama',
            'user:id,name,email',
            'dus_arsip:id,nomor_dus,rak_arsip_id',
            'rak_arsip:id,nomor_rak'
        ])->latest()->get();  

        $masterKodes = MasterKode::all();

        // Filter Rak dan Dus berdasarkan OPD si user (Asumsi tabel rak & dus punya kolom opd_id)
        $dus_arsips = Dus_Arsip::where('opd_induk_id', $userOpdId)->get();
        $rak_arsips = Rak_Arsip::where('opd_induk_id', $userOpdId)->get();



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
                'opd_induk_id' => $request->opd_induk_id,
                'retensi' => $request->retensi,
                'retensiinaktif' => $request->retensiinaktif,
                'nomor' => $request->nomor,
                'status' => $request->status ?? 'input',
                'pemusnahan' => $request->pemusnahan,
                'created_by' => auth()->id(),
                'file' => $filePath,               
                'dus_arsip_id' => $request->dus_arsip_id, 
                'rak_arsip_id' => $request->rak_arsip_id, 
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
    public function edit_admin($id)
    { 
        $data = Arsip::with([
            'opd:id,opd_induk_id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'opd_induk:id,kode_instansi,instansi',
            'masterKode:id,kode,nama',
            'user:id,name,email',
            'dus_arsip:id,nomor_dus',
            'rak_arsip:id,nomor_rak'
        ])->findOrFail($id);

        $opds = Opd::all();
        $masterKodes = MasterKode::all();

        return view('arsip.edit-admin', compact('id',
            'data',
            'opds',
            'masterKodes'
        ));
    }

    public function edit($id)
    { 
        $data = Arsip::with([
            'opd:id,opd_induk_id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'opd_induk:id,kode_instansi,instansi',
            'masterKode:id,kode,nama',
            'user:id,name,email',
            'dus_arsip:id,nomor_dus',
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

    public function edit_nomor($id)
    { 
        $data = Arsip::select('id', 'nomor')->findOrFail($id);

        return view('arsip.edit-nomor', compact('id',
            'data'
        ));
    }


    /**
     * Update the specified resource in storage.
     */
    public function updateTahan(Request $request, $id)
    {
        $arsip = Arsip::findOrFail($id); 
        $arsip->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'master_kode_id' => $request->master_kode_id,
            'opd_id' => $request->opd_id,
            'opd_induk_id' => $request->opd_induk_id,
            'retensi' => $request->retensi,
            'nomor' => $request->nomor,
            'status' => $request->status,
            'pemusnahan' => $request->pemusnahan, 
            'dus_arsip_id' => $request->dus_arsip_id,
            'rak_arsip_id' => $request->rak_arsip_id, 
        ]);

        return redirect()->route('arsip.home')
            ->with('success', 'Data berhasil diupdate');
    }

    public function update(Request $request, $id)
    {
        $arsip = Arsip::findOrFail($id); 

        // 1. Ambil hanya input yang ada di dalam form Blade yang disubmit
        $dataToUpdate = $request->only([
            'judul', 'deskripsi', 'tanggal', 'master_kode_id', 
            'opd_id', 'opd_induk_id', 'retensi', 'nomor', 
            'status', 'pemusnahan', 'dus_arsip_id', 'rak_arsip_id'
        ]);

        // 2. Filter data: Hanya update kolom yang benar-benar dikirim dari Form (mencegah NULL tidak sengaja)
        $dataToUpdate = array_filter($dataToUpdate, function ($value, $key) use ($request) {
            // Khusus untuk input 'nomor', jika dikosongkan (string kosong), kita tetap loloskan agar terupdate jadi NULL di DB
            if ($key === 'nomor') {
                return true; 
            }
            
            // Kolom lainnya hanya diupdate jika memang ada inputnya di form Blade
            return $request->has($key);
        }, ARRAY_FILTER_USE_BOTH);

        // 3. Eksekusi perubahan ke database
        $arsip->update($dataToUpdate);

        return redirect()->route('arsip.home')
            ->with('success', 'Data berhasil diupdate');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // 1. Cari data arsip berdasarkan ID, jika tidak ada akan otomatis error/404
            $arsip = Arsip::findOrFail($id);
    
            // 2. [Opsional] Hapus file PDF fisik dari storage jika filenya ada
            if ($arsip->file && file_exists(public_path('arsip/' . $arsip->file))) {
                unlink(public_path('arsip/' . $arsip->file));
            }
    
            // 3. Hapus data dari database
            $arsip->delete();
    
            // 4. Kembali ke halaman utama dengan pesan sukses
            return redirect()->route('arsip.home')
                ->with('success', 'Data arsip dan file terkait berhasil dihapus!');
    
        } catch (\Throwable $e) {
            // Jika gagal, tangkap errornya dan kembalikan dengan pesan error
            return redirect()->route('arsip.home')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
