<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class DokumenSiswa extends Model
{
    use HasFactory;

    protected $table = 'dokumen_siswa';

    protected $primaryKey = 'id_dokumen';

    protected $fillable = [
        'id_calon_siswa',
        'id_jenis_dokumen',
        'nama_file',
        'file_path',
        'tipe_file',
        'ukuran_file',
        'status_verifikasi',
        'catatan_verifikasi',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'ukuran_file' => 'integer',
    ];

    public function calonSiswa(): BelongsTo
    {
        return $this->belongsTo(CalonSiswa::class, 'id_calon_siswa', 'id_calon_siswa');
    }

    public function jenisDokumen(): BelongsTo
    {
        return $this->belongsTo(JenisDokumen::class, 'id_jenis_dokumen', 'id_jenis_dokumen');
    }

    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * URL publik untuk file
     */
    public function getFileUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }
}
