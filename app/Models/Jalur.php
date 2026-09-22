<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jalur extends Model
{
    use HasFactory;

    protected $table = 'jalur';

    protected $primaryKey = 'id_jalur';

    protected $fillable = [
        'id_tahun_ajaran',
        'nama_jalur',
        'kode_jalur',
        'kuota',
        'deskripsi',
        'persyaratan_khusus',
        'is_active',
    ];

    protected $casts = [
        'kuota'     => 'integer',
        'is_active' => 'boolean',
    ];

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran', 'id_tahun_ajaran');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
