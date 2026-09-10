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
        $users = User::with('opd_induk')->get();
        return view('users.index', compact('users'));
    }

    // form create dan show daftar opd saat register
    public function create()
    {
        $opds = Opd::orderBy('instansi')->get();
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

        $data = $request->except('password');

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
            'phone_number'   => 'required',
            'password' => 'required',
        ], [
            'phone_number.required' => 'Nomor harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        $credentials = [
            'phone_number' => $request->phone_number,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect()->intended('/app/dashboard-admin'); 
            }

            // Semua role lain (pengolah, sekretariat, staff, customer) memakai
            // dashboard yang sama; CustomerController::index() sudah menyesuaikan
            // tampilan berdasarkan opd/unit_kerja user yang login.
            return redirect()->intended('/app/dashboard');
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
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/pengolah');
    }
}
