<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rak_arsip extends Model
{
    //
    protected $table = 'rak_arsips';

    protected $fillable = [ 
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
    // OPD Induk
    public function opd_induk()
    {
        return $this->belongsTo(Opd_Induk::class, 'opd_induk_id');
    }
}
