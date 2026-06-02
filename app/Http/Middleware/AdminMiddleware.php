<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login
        $apakahUserSudahLogin = Auth::check();

        if ($apakahUserSudahLogin == true)
        {
            // Ambil data user yang sedang login
            $dataUserYangLogin = Auth::user();

            // Ambil role user
            $roleUser = $dataUserYangLogin->role;

            // Cek apakah role adalah admin
            if ($roleUser == 'admin')
            {
                // Izinkan request lanjut ke halaman berikutnya
                return $next($request);
            }
        }

        // Tolak akses jika belum login atau bukan admin
        abort(403);

    }
}
