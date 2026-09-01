<?php

namespace App\Exports;

use App\Models\Arsip;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ArsipExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        $user = auth()->user(); // load('opd'); 
        // Pilih kolom spesifik untuk mengurangi beban memori
        $data_filter = Arsip::select(
            'id', 
            'judul',
            'deskripsi',
            'file',
            'tahun',
            'periode_id',
            'tanggal',
            'tanggal_musnah',
            'aktif',
            'inaktif',
            'nomor',
            'status',
            'pemusnahan'   
        )->where('opd_induk_id', $user->opd_induk_id);
        if ($user->opd && strtolower($user->opd->unit_kerja) !== 'sekretariat') {
            $data_filter->where('opd_id', $user->opd_id); 
        }
        return $data_filter->latest()->get(); 

    }

    public function headings(): array
    {
        return [
            'id', 
            'judul',
            'deskripsi',
            'file',
            'tahun',
            'periode_id',
            'tanggal',
            'tanggal_musnah',
            'aktif',
            'inaktif',
            'nomor',
            'status',
            'pemusnahan'   
        ];
    }
}