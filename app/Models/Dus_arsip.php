<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dus_arsip extends Model
{
    //
    protected $table = 'dus_arsips';

    protected $fillable = [ 
        'nomor_dus',
        'nomor_rak',
        'opd_id', 
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

    // OPD
    public function rak_arsip()
    {
        return $this->belongsTo(Rak_arsip::class, 'nomor_rak');
    }
    //
}
