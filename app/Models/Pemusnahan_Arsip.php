<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemusnahan_Arsip extends Model
{
    //
    protected $table = 'pemusnahan_arsips';

    protected $fillable = [     
        'judul',
        'id_arsip',
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
        'korektor',
        'no_ba',
        'file_ba'
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

    //
}
