<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opd_induk extends Model
{
    protected $table = 'opd_induks';

    protected $fillable = [
        'kode_instansi',
        'instansi',
        'singkatan_instansi' 
    ]; 

    public function arsips()
    {
        return $this->hasMany(Arsip::class, 'opd_induk_id');
    }
}