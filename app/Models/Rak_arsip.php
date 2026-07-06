<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rak_arsip extends Model
{
    //
    // 1. Tambahkan baris ini untuk mematikan created_at dan updated_at
    public $timestamps = false; 

    protected $table = 'rak_arsips';

    protected $fillable = [ 
        'nomor_rak',
        'opd_id', 
        'opd_induk_id'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */
    // Parent Dus Arsip
    public function dus_arsips()
    {
        return $this->hasMany(Dus_arsip::class, 'rak_arsip_id');
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

}
