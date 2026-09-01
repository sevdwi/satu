<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Opd;
use App\Models\Opd_Induk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'password' => 'required'
        ], [
            // 'name.required' => 'Nomor harus diisi',
            'phone_number.required' => 'Nomor harus diisi',
            'password.required' => 'Password harus diisi'
        ]);

        $credentials = [
            // 'name' => $request->name,
            'phone_number' => $request->phone_number,
            'password' => $request->password
        ];
        // dd($credentials);
        // dd($request->remember);

        if (Auth::guard('web')->attempt($credentials)) {

            $request->session()->regenerate();

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