<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    public $timestamps = false; 

    protected $table = 'periodes';

    protected $fillable = [
        'opd_id',
        'tahun',
        'tahap',
        'status',
    ]; 

    // public function arsips()
    // {
    //     return $this->hasMany(Arsip::class, 'opd_id');
    // }

    // public function users()
    // {
    //     return $this->hasMany(User::class, 'opd_id');
    // }

    public function arsips()
    {
        return $this->hasMany(Arsip::class, 'periode_id');
    }


    public function opd()
    {
        return $this->belongsTo(Opd::class, 'opd_id');
    }



}