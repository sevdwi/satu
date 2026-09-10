<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Opd;
use App\Models\Arsip;
use App\Models\MasterKode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    // list semua admin
    public function index()
    {
        $user = Auth::guard('admin')->user();

        $data = Arsip::with([
            'opd_induk:id,instansi'
        ])
        ->latest()->get(); 
        $jumlah_data = $data->count();

        $rekap = $data->groupBy('opd_induk_id')->map(function ($item) {
            return [
                'instansi' => $item->first()->opd_induk->instansi ?? 'Tidak Diketahui',
                'jumlah' => $item->count()
            ];
        })->values();

        $labels = $rekap->pluck('instansi');
        $totals = $rekap->pluck('jumlah');

        $total_lewat = Arsip::where('tanggal_musnah', '<', now()->toDateString())->count();

        $hariIni = Carbon::now();
        $bulanDepan = Carbon::now()->addMonth();

        $data_musnah = Arsip::with(['opd_induk:id,instansi'])
                ->whereBetween('tanggal_musnah', [$hariIni, $bulanDepan])
                ->get();

        $rekapitulasi = $data_musnah->groupBy('opd_induk_id')->map(function ($grup) {
            return [
                'instansi_musnah' => $grup->first()->opd_induk->instansi ?? 'Tidak Diketahui',
                'jumlah_musnah' => $grup->count()
            ];
        })->values();

        $labelGrafik_musnah = $rekapitulasi->pluck('instansi_musnah');
        $dataGrafik_musnah = $rekapitulasi->pluck('jumlah_musnah');

        return view('dashboard-admin', compact('user', 'data','labels', 'totals','jumlah_data','total_lewat','labelGrafik_musnah','dataGrafik_musnah'));
    }

    // form create dan show daftar opd saat register
    public function create()
    {
        $opds = Opd::orderBy('instansi')->get();
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
            'role'     => 'admin',
            'status'   => 'active',
        ]);

        return redirect()->route('login-admin');
    }
    public function show(User $user)
    {
        return view('users.edit', compact('user'));
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
            'phone_number'   => 'required',
            'password' => 'required'
        ], [
            'phone_number.required' => 'Nomor harus diisi',
            'password.required' => 'Password harus diisi'
        ]);

        $credentials = [
            'phone_number' => $request->phone_number,
            'password' => $request->password,
            'role' => 'admin'
        ];

        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {

            $request->session()->regenerate();

            return redirect()->intended('/app/dashboard-admin');
        }

        $user = User::where('phone_number', $request->phone_number)->first();

        if ($user != null && $user->role != 'admin') {
            return back()
                ->withInput()
                ->withErrors([
                    'login' => 'Bukan admin!!!'
                ]);
        }

        return back()
            ->withInput()
            ->withErrors([
                'login' => 'Nomor atau password salah!!!'
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
