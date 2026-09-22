<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Biaya extends Model
{
    use HasFactory;

    protected $table = 'biaya_ppdb';

    protected $primaryKey = 'id_biaya';

    public const KATEGORI_BIAYA = [
        'pendaftaran'  => 'Biaya Formulir / Pendaftaran',
        'uang_pangkal' => 'Uang Pangkal / Pembangunan',
        'spp'          => 'SPP Bulanan',
        'seragam'      => 'Biaya Seragam',
        'buku'         => 'Biaya Buku & Modul',
        'kegiatan'     => 'Biaya Kegiatan / Operasional',
        'lainnya'      => 'Biaya Lain-lain',
    ];

    public const TIPE_PEMBAYARAN = [
        'sekali_bayar' => 'Sekali Bayar (Lunas Saat Masuk)',
        'bulanan'      => 'Rutin Bulanan',
        'sukarela'     => 'Sukarela / Infaq',
    ];

    protected $fillable = [
        'id_tahun_ajaran',
        'id_gelombang',
        'id_jalur',
        'nama_biaya',
        'jenis_biaya',
        'nominal',
        'tipe_pembayaran',
        'is_wajib',
        'is_active',
        'keterangan',
    ];

    protected $casts = [
        'nominal'   => 'decimal:2',
        'is_wajib'  => 'boolean',
        'is_active' => 'boolean',
    ];

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran', 'id_tahun_ajaran');
    }

    public function gelombang(): BelongsTo
    {
        return $this->belongsTo(Gelombang::class, 'id_gelombang', 'id_gelombang');
    }

    public function jalur(): BelongsTo
    {
        return $this->belongsTo(Jalur::class, 'id_jalur', 'id_jalur');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
