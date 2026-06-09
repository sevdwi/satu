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
}
