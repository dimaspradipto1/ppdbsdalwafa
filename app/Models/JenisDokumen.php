<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisDokumen extends Model
{
    use HasFactory;

    protected $table = 'ref_jenis_dokumen';

    protected $primaryKey = 'id_jenis_dokumen';

    protected $fillable = [
        'kode',
        'nama_dokumen',
        'kategori',
        'jumlah_lembar',
        'keterangan',
        'is_wajib',
        'is_active',
    ];

    protected $casts = [
        'is_wajib'  => 'boolean',
        'is_active' => 'boolean',
    ];

    public function dokumenSiswa(): HasMany
    {
        return $this->hasMany(DokumenSiswa::class, 'id_jenis_dokumen', 'id_jenis_dokumen');
    }
}
