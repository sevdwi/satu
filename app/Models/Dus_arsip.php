<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dus_arsip extends Model
{
    //
    // 1. Tambahkan baris ini untuk mematikan created_at dan updated_at
    public $timestamps = false; 

    protected $table = 'dus_arsips';

    protected $fillable = [ 
        'nomor_dus',
        'nomor_rak',
        'opd_id', 
        'opd_induk_id'
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

    // OPD Induk
    public function opd_induk()
    {
        return $this->belongsTo(Opd_Induk::class, 'opd_induk_id');
    }

    // rak
    public function rak_arsip()
    {
        return $this->belongsTo(Rak_arsip::class, 'rak_arsip_id');
    }
    
    
}
