<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_ppdb';
    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'id_calon_siswa',
        'id_biaya',
        'kode_transaksi',
        'nominal',
        'metode_pembayaran',
        'nama_bank_pengirim',
        'nomor_rekening_pengirim',
        'atas_nama_pengirim',
        'bukti_transfer',
        'status_pembayaran',
        'catatan',
        'verified_by',
        'verified_at',
        'tanggal_bayar',
    ];

    protected $casts = [
        'nominal'       => 'decimal:2',
        'tanggal_bayar' => 'datetime',
        'verified_at'   => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->kode_transaksi)) {
                $model->kode_transaksi = static::generateKodeTransaksi();
            }
            if (empty($model->tanggal_bayar)) {
                $model->tanggal_bayar = now();
            }
        });
    }

    public static function generateKodeTransaksi(): string
    {
        $year = date('Y');
        $month = date('m');
        $count = static::whereYear('created_at', $year)->whereMonth('created_at', $month)->count();
        return sprintf('INV-%s%s-%04d', $year, $month, $count + 1);
    }

    public function calonSiswa(): BelongsTo
    {
        return $this->belongsTo(CalonSiswa::class, 'id_calon_siswa', 'id_calon_siswa');
    }

    public function biaya(): BelongsTo
    {
        return $this->belongsTo(Biaya::class, 'id_biaya', 'id_biaya');
    }

    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
