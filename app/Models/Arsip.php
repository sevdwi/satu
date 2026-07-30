<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    protected $table = 'arsips';

    protected $fillable = [
        'judul',
        'deskripsi',
        'file',
        'tanggal',
        'tanggal_musnah',
        'master_kode_id',
        'created_by',
        'opd_id',
        'opd_induk_id',
        'dus_arsip_id',
        'rak_arsip_id',
        'korektor',
        'aktif',
        'inaktif',
        'nomor',
        'status',
        'pemusnahan',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    // OPD
    public function dus_arsip()
    {
        return $this->belongsTo(Dus_Arsip::class, 'dus_arsip_id');
    }
    public function rak_arsip()
    {
        return $this->belongsTo(Rak_Arsip::class, 'rak_arsip_id');
    }

    // OPD
    public function opd()
    {
        return $this->belongsTo(Opd::class, 'opd_id');
    }

    // OPD Induk
    public function opd_induk()
    {
        return $this->belongsTo(Opd_Induk::class, 'opd_induk_id');
    }
    

    // Master Kode
    public function masterKode()
    {
        return $this->belongsTo(MasterKode::class, 'master_kode_id');
    }

    // User (pembuat arsip)
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */

    // cek apakah arsip aktif
    public function isActive()
    {
        return $this->status === 'aktif';
    }

    // cek apakah sudah masuk masa pemusnahan
    public function isExpired()
    {
        if (!$this->pemusnahan) return false;

        return now()->greaterThan($this->pemusnahan);
    }
}