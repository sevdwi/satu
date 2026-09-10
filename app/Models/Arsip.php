<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    protected $table = 'arsips';

    protected $fillable = [
        'judul',
        'deskripsi',
        'file',
        'tahun',
        'periode_id',
        'tanggal',
        'tanggal_musnah',
        'master_kode_id',
        'created_by',
        'opd_id',
        'opd_induk_id',
        'dus_arsip_id',
        'rak_arsip_id',
        'korektor',
        'aktif',
        'inaktif',
        'nomor',
        'status',
        'nasib_akhir',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    public function dus_arsip()
    {
        return $this->belongsTo(Dus_Arsip::class, 'dus_arsip_id');
    }
    public function rak_arsip()
    {
        return $this->belongsTo(Rak_Arsip::class, 'rak_arsip_id');
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class, 'opd_id');
    }

    public function opd_induk()
    {
        return $this->belongsTo(Opd_Induk::class, 'opd_induk_id');
    }

    public function masterKode()
    {
        return $this->belongsTo(MasterKode::class, 'master_kode_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPE
    |--------------------------------------------------------------------------
    */

    /**
     * Eager-load relasi standar yang dipakai berulang di ArsipController.
     */
    public function scopeLengkap($query)
    {
        return $query->with([
            'opd:id,opd_induk_id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
            'opd_induk:id,kode_instansi,instansi',
            'masterKode:id,kode,nama',
            'user:id,name,email',
            'dus_arsip:id,nomor_dus',
            'rak_arsip:id,nomor_rak',
            'periode:id,tahun,tahap,status',
        ]);
    }

    /**
     * Batasi query hanya ke data milik instansi induk user yang login, dan
     * kalau bukan sekretariat, batasi lagi ke bidang (opd) miliknya sendiri.
     * Menggantikan pengecekan unit_kerja==='sekretariat' yang tadinya
     * diduplikasi di banyak controller (lihat AUDIT-KODE-SATU.md 4.3).
     */
    public function scopeMilikUser($query, $user = null)
    {
        $user = $user ?: auth()->user();

        $query->where('opd_induk_id', $user->opd_induk_id);

        if ($user->opd && strtolower($user->opd->unit_kerja) !== 'sekretariat') {
            $query->where('opd_id', $user->opd_id);
        }

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */

    /**
     * Arsip dianggap aktif selama belum punya keputusan akhir (musnah/permanen).
     * Sebelumnya membandingkan status dengan 'aktif', padahal enum status
     * hanya berisi verify/input/draft — nilai itu tidak pernah tercapai.
     */
    public function isActive()
    {
        return is_null($this->nasib_akhir);
    }

    public function isExpired()
    {
        if (!$this->tanggal_musnah) return false;

        return now()->greaterThan($this->tanggal_musnah);
    }
}
