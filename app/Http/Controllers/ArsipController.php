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
use App\Models\Periode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Exports\ArsipExport;
use App\Exports\ArsipExportAdmin;
use Maatwebsite\Excel\Facades\Excel;


class ArsipController extends Controller
{
    /**
     * Redirect target arsip.home/arsip_admin.home-admin sesuai role user
     * yang login. Dipakai oleh method yang dipakai bersama admin & user
     * (destroy, uploads_post) — sebelumnya dicek lewat guard('admin'),
     * sekarang cukup 1 guard ('web') jadi dicek lewat role saja.
     */
    private function homeRouteAktif()
    {
        return $this->isAdmin() ? 'arsip_admin.home-admin' : 'arsip.home';
    }

    private function isAdmin(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function dashbord(){

        $dataKategori = MasterKode::withCount('arsips')->get();

        $warna = [
            '#0d6efd', '#198754', '#ffc107', '#dc3545',
            '#6f42c1', '#20c997', '#fd7e14', '#6610f2'
        ];

        $icons = [
            'bi-folder-fill', 'bi-file-earmark-text-fill', 'bi-archive-fill',
            'bi-journal-bookmark-fill', 'bi-file-earmark-bar-graph-fill',
            'bi-collection-fill', 'bi-folder2-open', 'bi-files'
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
                'total' => $item->arsips_count,
                'color' => $color,
                'icon' => $icon
            ];

            $chartLabels[] = $item->nama;
            $chartData[] = $item->arsips_count;
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
        $user = auth()->user();  
        $userid = auth()->id();

        $data = Arsip::lengkap()->milikUser($user)->latest()->get(); 

        $arsipBelumDefinitif = Arsip::where('opd_induk_id', $user->opd_induk_id)
            ->whereNull('nomor')
            ->count();

        return view('arsip.index', compact('data','userid','arsipBelumDefinitif'));
    }

    public function index_tahap($tahap = null)
    {
        session(['periodes' => $tahap]);

        $user = auth()->user();  
        $userid = auth()->id();

        $data_filter = Arsip::lengkap()->milikUser($user);

        if ($tahap) {
            $data_filter->whereHas('periode', function ($q) use ($tahap) {
                $q->where('tahap', $tahap);
            });
        }

        $data = $data_filter->latest()->get(); 

        $arsipBelumDefinitif = Arsip::where('opd_induk_id', $user->opd_induk_id)
            ->whereNull('nomor')
            ->count();

        return view('arsip.index-tahap', compact('data','userid','arsipBelumDefinitif'));
    }


    public function manuver($periode = null)
    {
        session(['periodes' => $periode]);

        $user = auth()->user();
        $userid = auth()->id();

        $data_filter = Arsip::lengkap()->milikUser($user);

        if ($periode) {
            $data_filter->whereHas('periode', function ($q) use ($periode) {
                $q->where('tahap', $periode);
            });
        }

        $data = $data_filter->latest()->get(); 

        return view('arsip.index-manuver', compact('data','userid'));
    }

    public function musnah()
    {
        $user = auth()->user();
        $userid = auth()->id();

        $data = Arsip::lengkap()->milikUser($user)
            ->where('nasib_akhir', 'musnah')
            ->latest()->get();    
    
        return view('arsip.index-musnah', compact('data','userid'));
    }

    public function permanen()
    {
        $user = auth()->user();
        $userid = auth()->id();

        $data = Arsip::lengkap()->milikUser($user)
            ->where('nasib_akhir', 'permanen')
            ->latest()->get();    
    
        return view('arsip.index-permanen', compact('data','userid'));
    }

    public function index_admin()
    {
        $user = Auth::user();

        $opd_induk = Opd_Induk::orderBy('instansi')->get();

        $data = Arsip::lengkap()->latest()->get(); 

        return view('arsip.index-admin', compact('user', 'data','opd_induk'));
    }


    public function detail_admin($opd_induk_id)
    {        
        $opd_induk = Opd_Induk::findOrFail($opd_induk_id);

        $data_arsip = Arsip::lengkap()
            ->where('opd_induk_id', $opd_induk_id)
            ->latest()
            ->get();

        return view('arsip.detail-admin', compact('opd_induk', 'data_arsip'));
    }

    public function musnah_admin()
    {
        $user = Auth::user();

        $opd_induk = Opd_Induk::orderBy('instansi')->get();

        $data = Arsip::lengkap()
            ->where('nasib_akhir', 'musnah')
            ->latest()->get(); 

        return view('arsip.index-musnah-admin', compact('user', 'data','opd_induk'));
    }

    public function permanen_admin()
    {
        $user = Auth::user();

        $opd_induk = Opd_Induk::orderBy('instansi')->get();

        $data = Arsip::lengkap()
            ->where('nasib_akhir', 'permanen')
            ->latest()->get(); 

        return view('arsip.index-permanen-admin', compact('user', 'data','opd_induk'));
    }

    public function uploads_post(Request $request){
        $request->validate([
            'id' => 'required|integer',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:51200', // +-50Mb
        ]);

        if ($this->isAdmin()) {
            $arsip = Arsip::findOrFail($request->id);
        } else {
            $arsip = Arsip::milikUser()->findOrFail($request->id);
        }

        $file = $request->file('file');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeName = Str::slug($originalName);
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '_' . $safeName . '.' . $extension;

        $file->move(public_path('arsip'), $filename);

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
        ->milikUser()
        ->where(function ($query) use ($q) {
            $query->where('judul', 'like', "%{$q}%")
                  ->orWhere('nomor', 'like', "%{$q}%")
                  ->orWhere('tanggal', 'like', "%{$q}%")
                  ->orWhereHas('opd', function ($sub) use ($q) {
                      $sub->where('instansi', 'like', "%{$q}%")
                          ->orWhere('singkatan_instansi', 'like', "%{$q}%")
                          ->orWhere('unit_kerja', 'like', "%{$q}%")
                          ->orWhere('singkatan_uk', 'like', "%{$q}%");
                  });
        })
        ->limit(20)
        ->get();

        return response()->json($data);
    }

    public function create()
    {
        $user = auth()->user(); 
        $userOpdId = $user->opd_induk_id; 
        $userUnit = $user->opd_id;
       
        $opds = Opd::where('id', $userUnit)->get();
        $periodes = Periode::where('opd_id', $userUnit)->latest('id')->first();
        $opdinduks = Opd_Induk::where('id', $userOpdId)->get();

        if (!$periodes) {
            return redirect()->route('periode.create')
                ->with('error', 'Buat periode/tahap arsip untuk unit kerja Anda terlebih dahulu sebelum menambah arsip.');
        }

        $data = Arsip::with([
            'opd:id,opd_induk_id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'masterKode:id,kode,nama,aktif,inaktif,keterangan',
            'user:id,name,email',
            'dus_arsip:id,nomor_dus,rak_arsip_id',
            'rak_arsip:id,nomor_rak'
        ])->latest()->get();  

        $masterKodes = MasterKode::all();

        $dus_arsips = Dus_Arsip::where('opd_induk_id', $userOpdId)->get();
        $rak_arsips = Rak_Arsip::where('opd_induk_id', $userOpdId)->get();

        return view('arsip.create', compact(
            'data',
            'opds',
            'opdinduks',
            'masterKodes',
            'dus_arsips',
            'rak_arsips',
            'periodes'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    { 
        $tanggal = $request->tanggal;
        $aktif = (int) $request->aktif;
        $inaktif = (int) $request->inaktif;

        $totalTahun = $aktif + $inaktif;

        $tanggalMusnah = null;
        if ($tanggal) {
            $tanggalMusnah = Carbon::parse($tanggal)->addYears($totalTahun)->format('Y-m-d');
        }

        Arsip::create([
            'korektor' => $request->korektor ?: null,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tahun' => $request->tahun,
            'periode_id' => $request->periode_id,
            'tanggal' => $request->tanggal,
            'tanggal_musnah' => $tanggalMusnah,
            'master_kode_id' => $request->master_kode_id,
            'opd_id' => $request->opd_id,
            'opd_induk_id' => $request->opd_induk_id,
            'aktif' => $request->aktif,
            'inaktif' => $request->inaktif,
            'nomor' => $request->nomor,
            'status' => $request->status ?? 'input',
            'created_by' => auth()->id(),
            'file' => $request->file,               
            'dus_arsip_id' => $request->dus_arsip_id ?: null, 
            'rak_arsip_id' => $request->rak_arsip_id ?: null, 
        ]);
        
        return redirect()->route('arsip.home')
            ->with('success', 'Data berhasil ditambahkan!');  
    } 

    /**
     * Show the form for editing the specified resource.
     */
    public function edit_admin($id)
    { 
        $data = Arsip::lengkap()->findOrFail($id);

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
        $user = auth()->user(); 
        $userUnit = $user->opd_id;

        $data = Arsip::lengkap()->milikUser($user)->findOrFail($id);

        // Pakai periode yang SUDAH melekat di arsip ini, bukan "periode
        // terbaru unit" — sebelumnya form edit selalu menimpa periode_id
        // arsip dengan periode terbaru unit kerja lewat hidden input,
        // jadi setiap kali arsip diedit, periode aslinya ikut berubah
        // tanpa disengaja. Fallback ke periode terbaru unit hanya kalau
        // arsip ini memang belum punya periode sama sekali.
        $periodes = $data->periode ?: Periode::where('opd_id', $userUnit)->latest('id')->first();

        $opds = Opd::all();
        $masterKodes = MasterKode::all();

        return view('arsip.edit', compact('id',
            'data',
            'opds',
            'periodes',
            'masterKodes'
        ));
    }

    public function edit_nomor($id)
    { 
        $data = Arsip::milikUser()->select('id', 'nomor')->findOrFail($id);

        return view('arsip.edit-nomor', compact('id',
            'data'
        ));
    }

    public function nomor_definitif(Request $request)
    {
        $request->validate([
            'nomor' => 'required|array',
            'nomor.*' => 'nullable|numeric' 
        ]);

        foreach ($request->nomor as $id => $nomorDefinitif) {
            Arsip::milikUser()->where('id', $id)->update([
                'nomor' => $nomorDefinitif
            ]);
        }

        return redirect()->back()->with('success', 'Nomor definitif berhasil diperbarui secara massal!');
    }

    public function edit_status($id)
    { 
        $data = Arsip::milikUser()->select('id', 'status')->findOrFail($id);

        return view('arsip.edit-status', compact('id',
            'data'
        ));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $arsip = Arsip::milikUser()->findOrFail($id); 

        $tanggal = $request->tanggal;
        $aktif = (int) $request->aktif;
        $inaktif = (int) $request->inaktif;

        $totalTahun = $aktif + $inaktif;

        $tanggalMusnah = null;
        if ($tanggal) {
            $tanggalMusnah = Carbon::parse($tanggal)->addYears($totalTahun)->format('Y-m-d');
        }

        $dataToUpdate = $request->only([
            'judul', 'deskripsi','tahun','periode_id','tanggal', 'master_kode_id', 
            'opd_id', 'opd_induk_id', 'aktif','inaktif', 'nomor', 
            'status', 'nasib_akhir', 'file', 'dus_arsip_id', 'rak_arsip_id'
        ]);

        if ($tanggalMusnah) {
            $dataToUpdate['tanggal_musnah'] = $tanggalMusnah;
        }

        $dataToUpdate = array_filter($dataToUpdate, function ($value, $key) use ($request) {
            if ($key === 'nomor') {
                return true; 
            }
            return $request->has($key);
        }, ARRAY_FILTER_USE_BOTH);

        $arsip->update($dataToUpdate);

        return redirect()->route('arsip.home')
            ->with('success', 'Data berhasil diupdate');
    }

    public function update_admin(Request $request, $id)
    {
        $arsip = Arsip::findOrFail($id); 

        $dataToUpdate = $request->only([
            'judul', 'deskripsi', 'tanggal','tanggal_musnah', 'master_kode_id', 
            'opd_id', 'opd_induk_id', 'nomor', 
            'status', 'nasib_akhir', 'file', 'dus_arsip_id', 'rak_arsip_id'
        ]);

        $dataToUpdate = array_filter($dataToUpdate, function ($value, $key) use ($request) {
            if ($key === 'status') {
                return true; 
            }
            return $request->has($key);
        }, ARRAY_FILTER_USE_BOTH);

        $arsip->update($dataToUpdate);

        return redirect()->route('arsip_admin.home-admin')
            ->with('success', 'Data berhasil diupdate');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            if ($this->isAdmin()) {
                $arsip = Arsip::findOrFail($id);
            } else {
                $arsip = Arsip::milikUser()->findOrFail($id);
            }
    
            if ($arsip->file && file_exists(public_path('arsip/' . $arsip->file))) {
                unlink(public_path('arsip/' . $arsip->file));
            }
    
            $arsip->delete();
    
            return redirect()->route($this->homeRouteAktif())
                ->with('success', 'Data arsip dan file terkait berhasil dihapus!');
    
        } catch (\Throwable $e) {
            return redirect()->route($this->homeRouteAktif())
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function kartu($id)
    { 
        $data = Arsip::milikUser()->lengkap()->findOrFail($id);

        $opds = Opd::all();
        $masterKodes = MasterKode::all();

        return view('arsip.kartu', compact('id',
            'data',
            'opds',
            'masterKodes'
        ));
    }

    public function kosong()
    { 
        return view('arsip.surat-kosong');
    }

    public function exportExcel_admin()
    {
        return Excel::download(new ArsipExportAdmin, 'data_arsip_lengkap.xlsx');
    }

    public function exportExcel()
    {
        return Excel::download(new ArsipExport, 'data_arsip_lengkap.xlsx');
    }

}
