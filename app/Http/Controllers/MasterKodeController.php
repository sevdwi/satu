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
            'is_parent' => $isParent,
        ]);

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

        if ($parentId) {
            $childCount = MasterKode::where('parent_id', $parentId)->count();

            if ($childCount == 0) {
                MasterKode::where('id', $parentId)
                    ->update([
                        'is_parent' => false
                    ]);
            }
        }

        return redirect()->route('master-kodes.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function import()
    {
        return view('master-kodes.import');
    }

    public function store_import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');
        $fileHandle = fopen($file->getRealPath(), 'r');

        fgetcsv($fileHandle);

        while (($row = fgetcsv($fileHandle, 1000, ',')) !== false) {
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

            $id = empty($row[0]) ? null : (int) $row[0];

            if ($id !== null) {
                $data['id'] = $id;
            }

            MasterKode::create($data);
        }

        fclose($fileHandle);

        return back()->with('success', 'Sistem berhasil mengimpor data CSV ke MySQL.');
    }

}
