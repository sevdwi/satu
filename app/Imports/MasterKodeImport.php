<?php

namespace App\Imports;

use App\Models\MasterKode;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MasterKodeImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {

            // skip header
            if ($index == 0) continue;

            $kode = trim($row[0]);   // kolom A
            $uraian = trim($row[1]); // kolom B
            // dd($rows->toArray());
             // dd($row); // ✔️ lihat 1 baris saja

            if (!$kode) continue;

            // =========================
            // CARI PARENT DARI KODE
            // =========================
            $parentCode = $this->getParentCode($kode);

            $parent = null;
            $level = 1;

            if ($parentCode) {
                $parent = MasterKode::where('kode', $parentCode)->first();

                if ($parent) {
                    $level = $parent->level + 1;
                }
            }

            MasterKode::updateOrCreate(
                ['kode' => $kode],
                [
                    'nama' => $uraian,
                    'parent_id' => $parent?->id,
                    'level' => $level,
                    'is_parent' => true, // nanti dirapikan otomatis kalau punya child
                ]
            );

            // tandai parent kalau ada child
            if ($parent) {
                $parent->update([
                    'is_parent' => true
                ]);
            }
        }
    }

    /**
     * ambil parent dari kode
     * contoh:
     * 000.1.2 -> 000.1
     * 000.1 -> 000
     * 000 -> null
     */
    private function getParentCode($kode)
    {
        $parts = explode('.', $kode);

        if (count($parts) <= 1) {
            return null;
        }

        array_pop($parts);

        return implode('.', $parts);
    }
}