<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterKode extends Model
{
    // use HasFactory;

    public $timestamps = false; 

    protected $table = 'master_kodes';

    protected $fillable = [
        'id', 
        'is_parent',
        'parent_id',
        'level',
        'kode',
        'nama',
        'aktif',
        'inaktif',
        'keterangan',
    ];

    protected $casts = [
        'is_parent' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    // Parent
    // public function parent()
    // {
    //     return $this->belongsTo(MasterKode::class, 'parent_id');
    // }

    // Children
    public function arsips()
    {
        return $this->hasMany(Arsip::class, 'master_kode_id');
    }
}