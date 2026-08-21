<?php

namespace App\Exports;

use App\Models\Arsip;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ArsipExportAdmin implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        // Pilih kolom spesifik untuk mengurangi beban memori
        return Arsip::select(
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
        )->get();
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