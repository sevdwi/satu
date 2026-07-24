<?php

namespace App\Http\Controllers;

use App\Models\MasterKode;
use Illuminate\Http\Request;

class MasterKodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = MasterKode::latest()->get();

        return view('master-kodes.index', compact('data'));
    }
    // public function search2(Request $request)
    // {
    //     $q = $request->q; 

    //     $data = MasterKode::where('kode', 'like', "%$q%")
    //         ->orWhere('nama', 'like', "%$q%")
    //         ->orWhere('keterangan', 'like', "%$q%") 
    //         ->limit(20)
    //         ->get();

    //     return response()->json($data);
    // }
    public function search(Request $request)
    {
        $q = $request->q;
 
        $data = MasterKode::where('kode', 'like', "%$q%")
            ->orWhere('nama', 'like', "%$q%")
            ->limit(20)
            ->get();

        return response()->json($data);
    }

    public function edit($id)
    {
        $data = MasterKode::findOrFail($id);

        $parents = MasterKode::where('id', '!=', $id)->get();

        return view('master-kodes.edit', compact('data', 'parents'));
    }
    public function create()
    {
        $parents = MasterKode::all();
        $data['id']=0;

        return view('master-kodes.create', compact('data','parents'));
    } 
    // public function search(Request $request)
    // {
    //     $q = $request->q;
    //     $currentId = $request->current_id;

    //     $query = MasterKode::query()
    //         ->select('id', 'kode', 'nama')
    //         ->where(function ($x) use ($q) {
    //             $x->where('nama', 'like', "%{$q}%")
    //               ->orWhere('kode', 'like', "%{$q}%");
    //         });

    //     // ❌ jangan tampilkan dirinya sendiri saat edit
    //     if ($currentId) {
    //         $query->where('id', '!=', $currentId);
    //     }

    //     return $query->limit(20)->get();
    // }
    
    public function getdataajax()
    {
        $data = MasterKode::with('parent', 'children')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|unique:master_kodes,kode',
            'nama' => 'required',
            'parent_id' => 'nullable|exists:master_kodes,id',
            'keterangan' => 'nullable',
        ]);

        $isParent = is_null($request->parent_id);

        $level = 1;

        if (!$isParent) {
            $parent = MasterKode::find($request->parent_id);
            $level = $parent->level + 1;

            // pastikan parent ditandai sebagai parent
            $parent->update([
                'is_parent' => true
            ]);
        }

        MasterKode::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'parent_id' => $request->parent_id,
            'keterangan' => $request->keterangan,
            'level' => $level,
            'is_parent' => $isParent,
        ]);

        return redirect()
            ->route('master-kodes.index')
            ->with('success', 'Data berhasil disimpan');
    }
    public function storex(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|unique:master_kodes,kode',
            'nama' => 'required|string',
            'keterangan' => 'nullable|string',
            'parent_id' => 'nullable|exists:master_kodes,id',
        ]);

        // Tentukan level otomatis
        $level = 1;

        if ($request->parent_id) {
            $parent = MasterKode::find($request->parent_id);
            $level = $parent->level + 1;
        }

        $masterKode = MasterKode::create([
            'kode' => $validated['kode'],
            'nama' => $validated['nama'],
            'keterangan' => $validated['keterangan'] ?? null,
            'parent_id' => $validated['parent_id'] ?? null,
            'is_parent' => false,
            'level' => $level,
        ]);

        // Update parent jadi is_parent = true
        if ($request->parent_id) {
            $parent->update([
                'is_parent' => true
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'data' => $masterKode
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = MasterKode::with('parent', 'children')
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $masterKode = MasterKode::findOrFail($id);

        $validated = $request->validate([
            'kode' => 'required|string|unique:master_kodes,kode,' . $id,
            'nama' => 'required|string',
            'keterangan' => 'nullable|string',
            'parent_id' => 'nullable|exists:master_kodes,id',
        ]);

        $isParent = is_null($validated['parent_id']);

        $level = 1;

        if (!$isParent) {
            $parent = MasterKode::find($validated['parent_id']);

            // jaga-jaga kalau parent tidak ditemukan
            if ($parent) {
                $level = $parent->level + 1;
            }
        }

        $masterKode->update([
            'kode' => $validated['kode'],
            'nama' => $validated['nama'],
            'keterangan' => $validated['keterangan'] ?? null,
            'parent_id' => $validated['parent_id'],
            'level' => $level,
            'is_parent' => $isParent, // ✔️ penting biar konsisten
        ]);

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Data berhasil diupdate',
        //     'data' => $masterKode
        // ]);
        return redirect()->route('master-kodes.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $masterKode = MasterKode::findOrFail($id);

        $parentId = $masterKode->parent_id;

        $masterKode->delete();

        // Cek apakah parent masih punya child
        if ($parentId) {
            $childCount = MasterKode::where('parent_id', $parentId)->count();

            if ($childCount == 0) {
                MasterKode::where('id', $parentId)
                    ->update([
                        'is_parent' => false
                    ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function import()
    {
        return view('master-kodes.import');
    }

    public function store_import(Request $request)
    {
        // Sistem memvalidasi fail masukan
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');
        $fileHandle = fopen($file->getRealPath(), 'r');

        // Program melewati baris pertama jika CSV memiliki tajuk (header)
        fgetcsv($fileHandle);

        // Program mengulang setiap baris data
        // Program mengulang setiap baris data
        while (($row = fgetcsv($fileHandle, 1000, ',')) !== false) {
            // Program menyiapkan array asosiatif tanpa kolom id
            $data = [
                'is_parent'  => $row[1],
                'parent_id'  => (empty($row[2]) || $row[2] == 0) ? null : (int) $row[2],
                'level'      => empty($row[3]) ? 0 : (int) $row[3],
                'kode'       => $row[4],
                'nama'       => $row[5],
                'aktif'      => empty($row[6]) ? null : (int) $row[6],
                'inaktif'    => empty($row[7]) ? null : (int) $row[7],
                'keterangan' => empty($row[8]) ? null : $row[8],
            ];

            // Program memvalidasi eksistensi data ID pada baris CSV
            $id = empty($row[0]) ? null : (int) $row[0];

            // Program menyisipkan kunci id hanya jika data tersedia
            if ($id !== null) {
                $data['id'] = $id;
            }

            // Sistem menyimpan data ke pangkalan data MySQL
            MasterKode::create($data);
        }
        return back()->with('success', 'Sistem berhasil mengimpor data CSV ke MySQL.');
    }



}