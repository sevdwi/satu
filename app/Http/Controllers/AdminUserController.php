<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Opd;
use App\Models\Arsip;
use App\Models\MasterKode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    // list semua admin
    public function index()
    {
        $user = Auth::guard('admin')->user(); // Mengambil data dari provider 'users'

        $data = Arsip::with([
            'opd_induk:id,instansi' // Pastikan kolom 'instansi' ada di tabel opd_induk
            // 'opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            // 'masterKode:id,kode,nama',
            // 'user:id,name,email',
            // 'dus_arsip:id,nomor_dus',
            // 'rak_arsip:id,nomor_rak'
        ])
        ->where('status', '!=', 'inaktif')
        ->latest()->get(); 

        // Lakukan debug terlebih dahulu untuk melihat apakah data sudah terisi
        //dd($data->toArray()); 

        // Kelompokkan data dan hitung jumlah arsip per opd_induk
        $rekap = $data->groupBy('opd_induk_id')->map(function ($item) {
            return [
                'instansi' => $item->first()->opd_induk->instansi ?? 'Tidak Diketahui',
                'jumlah' => $item->count()
            ];
        })->values();

        // Siapkan array untuk Chart.js
        $labels = $rekap->pluck('instansi');
        $totals = $rekap->pluck('jumlah');

        return view('dashboard-admin', compact('user', 'data','labels', 'totals'));
    }

    // form create dan show daftar opd saat register
    public function create()
    {
        $opds = Opd::orderBy('instansi')->get(); // sesuaikan nama kolom
        return view('users.create', compact('opds'));
    }

    // simpan admin
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'phone_number'   => 'required|unique:users,phone_number',
            'password' => 'required|min:4',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone_number'   => $request->phone_number,
            'password' => $request->password, // auto hash oleh model
        ]);

        return redirect()->route('login-admin');
    }

    // form edit
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // update
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email',
        ]);

        $user->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('users.index');
    }

    // delete
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }

    // ------------------------------------------------------------------
    // AUTH ADMIN
    // ------------------------------------------------------------------

    // login form
    public function loginForm()
    {
        return view('auth.login-admin');
    }

    // proses login
    public function login(Request $request)
    {
        $request->validate([
            // 'name'   => 'required',
            'phone_number'   => 'required',
            'password' => 'required'
        ], [
            // 'name.required' => 'Nomor harus diisi',
            'phone_number.required' => 'Nomor harus diisi',
            'password.required' => 'Password harus diisi'
        ]);

        $credentials = [
            // 'name' => $request->name,
            'phone_number' => $request->phone_number,
            'password' => $request->password,
            'role' => 'admin'
        ];

        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {

            $request->session()->regenerate();

            return redirect()->intended('/app/dashboard-admin');
        }

        // Cari user di database
        $user = User::where(
            'phone_number',
            $request->phone_number
        )->first();

        // Jika user ada tetapi bukan admin
        if (
            $user != null
            &&
            $user->role != 'admin'
        )
        {
            return back()
                ->withInput()
                ->withErrors([

                    'login' =>
                    'Bukan admin!!!'

                ]);
        }

        // Login gagal biasa
        return back()
            ->withInput()
            ->withErrors([

                'login' =>
                'Nomor atau password salah!!!'

            ]);        
    }

    // logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/administrator');
    }
}