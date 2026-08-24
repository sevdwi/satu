<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Opd;
use App\Models\Arsip;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CustomerController extends Controller
{
    //
    // public function index(Request $request)
    
    public function index()
    {
    $user = Auth::guard('web')->user(); // Mengambil data dari provider 'users'

    // Ambil data user yang sedang login beserta id OPD-nya
    $userfilter = auth()->user()->opd; 
    
    // Ambil id user untuk kode sementara
    $userid = auth()->id();
    $user = auth()->user(); 

    // Pastikan nama kolom 'opd_id' sesuai di tabel users
    $userOpdId = $userfilter->opd_induk_id; 

    $periodes = Periode::where('opd_id', $user->opd_id)->latest('id')->first();
           
    $data_filter = Arsip::with([
        'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
        'masterKode:id,kode,nama',
        'user:id,name,email',
        'dus_arsip:id,nomor_dus',
        'rak_arsip:id,nomor_rak'
    ])
    ->where('opd_induk_id', $userOpdId);

    // Cek kondisi Unit Kerja user
    if ($user->opd && strtolower($user->opd->unit_kerja) !== 'sekretariat') {
        $data_filter->where('opd_id', $user->opd_id); 
    }

    // Eksekusi data utama
    $data = $data_filter->latest()->get(); 

    $jumlah_data = $data->count();

    // === PROSES DATA UNTUK CHART.JS ===
    // Kelompokkan berdasarkan 'opd_id' untuk menghitung jumlah arsip per unit kerja
    $rekap = $data->groupBy('opd_id')->map(function ($item) {
        return [
            // Gunakan 'singkatan_uk' atau 'unit_kerja' sesuai kebutuhan label chart Anda
            'unit_kerja' => $item->first()->opd->unit_kerja ?? 'Tidak Diketahui',
            'jumlah' => $item->count()
        ];
    })->values();

    // Siapkan array untuk Chart.js
    $labels = $rekap->pluck('unit_kerja');
    $totals = $rekap->pluck('jumlah');

    $total_lewat = Arsip::where('tanggal_musnah', '<', now()->toDateString())->where('opd_induk_id', $userOpdId)
    ->count();
    // echo "Total data yang sudah lewat: " . $total_lewat;


    // Kirim variabel 'labels' dan 'totals' ke view
    return view('dashboard', compact('user','data', 'userid', 'labels', 'totals','jumlah_data','total_lewat','periodes'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }


}
