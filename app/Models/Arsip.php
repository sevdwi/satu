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
        'master_kode_id',
        'created_by',
        'opd_id',
        'retensi',
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
    public function opd()
    {
        return $this->belongsTo(Opd::class, 'opd_id');
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