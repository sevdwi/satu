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

    public function opds()
    {
        return $this->hasMany(Opd::class, 'opd_induk_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'opd_induk_id');
    }

    public function rak_arsips()
    {
        return $this->hasMany(rak_arsip::class, 'opd_induk_id');
    }

}