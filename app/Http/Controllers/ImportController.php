<?php

namespace App\Http\Controllers;
use App\Models\MasterKode;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function index()
    {
        return view('master-kodes.import');
    }
}
