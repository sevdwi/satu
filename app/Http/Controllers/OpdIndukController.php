<?php

namespace App\Http\Controllers;

use App\Models\Opd_Induk;
use Illuminate\Http\Request;

class OpdIndukController extends Controller
{
    public function index()
    {
        $opd_induk = Opd_induk::all();
        return view('opd_induk.index', compact('opd_induk'));
    }

    
    public function search(Request $request)
    {
        $q = $request->q;
 
        $data = Opd_induk::where('instansi', 'like', "%$q%")
            ->orWhere('kode_instansi', 'like', "%$q%")
            // ->orWhere('singkatan_instansi', 'like', "%$q%")
            ->limit(20)
            ->get();

        return response()->json($data);
    }

}
