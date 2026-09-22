<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gelombang extends Model
{
    use HasFactory;

    protected $table = 'gelombang';

    protected $primaryKey = 'id_gelombang';

    protected $fillable = [
        'id_tahun_ajaran',
        'nama_gelombang',
        'tanggal_mulai',
        'tanggal_selesai',
        'kuota',
        'is_active',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
        'is_active'       => 'boolean',
        'kuota'           => 'integer',
    ];

    /**
     * Relasi ke Tahun Ajaran
     */
    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran', 'id_tahun_ajaran');
    }

    /**
     * Scope untuk gelombang yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
