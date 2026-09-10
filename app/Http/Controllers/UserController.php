<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Opd;
use App\Models\Opd_Induk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class UserController extends Controller
{
    // list semua user
    public function index()
    {
        // $users = User::all();
        $users = User::with('opd_induk')->get();
        return view('users.index', compact('users'));
    }

    // form create dan show daftar opd saat register
    public function create()
    {
        $opds = Opd::orderBy('instansi')->get(); // sesuaikan nama kolom
        $opd_induks = Opd_Induk::all();
        return view('users.create', compact('opds','opd_induks'));
    }

    // simpan user
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'phone_number'   => 'required|unique:users,phone_number',
            'password' => 'required|min:4',
            'status'       => 'required|in:active,banned,verify',
            'role'         => 'required',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone_number'   => $request->phone_number,
            // 'opd'     => $request->opd,
            'opd_id'     => $request->opd_id,
            'opd_induk_id'     => $request->opd_induk_id,
            'role' => $request->role,
            'status' => $request->status,
            'password' => $request->password, // auto hash oleh model
        ]);

        return redirect()->route('users.index');
    }

    // form edit
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // update
    public function updatetahan2(Request $request, User $user)
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

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'          => 'required',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'phone_number'  => 'required|unique:users,phone_number,' . $user->id,
            'password'      => 'nullable|min:4',
            'status'        => 'required|in:active,banned,verify',
            'role'          => 'required',
        ]);

        // Mengambil semua input kecuali password
        $data = $request->except('password');

        // Update password hanya jika user mengisi input password baru
        if ($request->filled('password')) {
            $data['password'] = $request->password; // auto hash tetap berjalan oleh model
        }

        $user->update($data);

        return redirect()->route('users.index');
    }


    // delete
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }

    // ------------------------------------------------------------------
    // AUTH user
    // ------------------------------------------------------------------

    // login form
    public function loginForm()
    {
        return view('auth.login');
    }

    // proses login
    public function login(Request $request)
    {

        $request->validate([
            // 'name'   => 'required',
            'phone_number'   => 'required',
            'password' => 'required',
            // 'g-recaptcha-response' => 'required',
        ], [
            // 'name.required' => 'Nomor harus diisi',
            'phone_number.required' => 'Nomor harus diisi',
            'password.required' => 'Password harus diisi',
            // 'g-recaptcha-response.required' => 'Silakan centang "Saya bukan robot".',
        ]);

        // CAPTCHA tidak valid
        // if (!($result['success'] ?? false)) {
        //     return back()
        //         ->withInput($request->only('phone_number'))
        //         ->withErrors([
        //             'g-recaptcha-response' => 'Verifikasi CAPTCHA gagal. Silakan coba lagi.',
        //         ]);
        // }
        // // Verifikasi reCAPTCHA ke Google
        // $response = Http::asForm()->post(
        //     'https://www.google.com/recaptcha/api/siteverify',
        //     [
        //         'secret' => config('services.recaptcha.secret_key'),
        //         'response' => $request->input('g-recaptcha-response'),
        //         'remoteip' => $request->ip(),
        //     ]
        // );

        // $result = $response->json(); 

        $credentials = [
            // 'name' => $request->name,
            'phone_number' => $request->phone_number,
            'password' => $request->password
        ];
        // dd($credentials);
        // dd($request->remember);


        // Cukup gunakan Auth::attempt standar (otomatis menggunakan guard 'web' dan tabel 'users')
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            // Ambil data hak akses/role dari user yang berhasil login
            $role = Auth::user()->role; // <-- GANTI 'role' SESUAI NAMA KOLOM DI DATABASE ANDA

            // Arahkan ke dashboard masing-masing sesuai perannya
            if ($role === 'admin') {
                return redirect()->intended('/app/dashboard-admin'); 
            } 
            
            if ($role === 'pengolah') {
                return redirect()->intended('/app/dashboard'); // Sesuaikan URL-nya
            }   
            // Jika rolenya tidak dikenali, lempar ke halaman default
            return redirect()->intended('/');
        }

        // Jika email/password salah
        // return back()->withErrors([
        //     'email' => 'Email atau password yang Anda masukkan salah.',
        // ])->onlyInput('email');

        return back()
            ->withInput()
            ->withErrors([
                'login' => 'Nomor atau password salah!!!'
            ]);
    }

    // logout
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/pengolah');
    }
}