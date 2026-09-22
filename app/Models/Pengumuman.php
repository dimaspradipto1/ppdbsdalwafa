<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman_ppdb';
    protected $primaryKey = 'id_pengumuman';

    protected $fillable = [
        'id_tahun_ajaran',
        'id_gelombang',
        'judul',
        'nomor_surat',
        'tanggal_buka',
        'isi_pengumuman',
        'file_lampiran',
        'is_published',
        'created_by',
    ];

    protected $casts = [
        'tanggal_buka' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran', 'id_tahun_ajaran');
    }

    public function gelombang(): BelongsTo
    {
        return $this->belongsTo(Gelombang::class, 'id_gelombang', 'id_gelombang');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
