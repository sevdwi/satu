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
        // Pilih kolom spesifik untuk mengurangi beban memori
        return Arsip::select('id', 'nomor', 'judul', 'tanggal')->get();
    }

    public function headings(): array
    {
        return [
            'ID Sistem',
            'Nomor Definitif',
            'Judul Arsip',
            'Tanggal Buat',
        ];
    }
}