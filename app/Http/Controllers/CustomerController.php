<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Opd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CustomerController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = Auth::guard('web')->user(); // Mengambil data dari provider 'users'
        return view('dashboard', compact('user'));
    }
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }


}
