<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterKode extends Model
{
    // use HasFactory;

    protected $table = 'master_kodes';

    protected $fillable = [
        'kode',
        'is_parent',
        'parent_id',
        'level',
        'nama',
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