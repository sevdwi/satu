<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\MasterKodeImport;
use Maatwebsite\Excel\Facades\Excel;

class MasterKodeImportController extends Controller
{
    public function index()
    {
        return view('master-kodes.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
        

        Excel::import(new MasterKodeImport, $request->file('file'));

        return redirect()
            ->back()
            ->with('success', 'Import berhasil');
    }
}