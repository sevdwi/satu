<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    protected $table = 'opds';

    protected $fillable = [
        'kode_instansi',
        'unit_kerja',
        'singkatan_uk',
        'instansi',
        'singkatan_instansi' 
    ]; 

    public function arsips()
    {
        return $this->hasMany(Arsip::class, 'opd_id');
    }

    public function opd_induk()
    {
        return $this->belongsTo(Opd_Induk::class, 'opd_induk_id');
    }

}