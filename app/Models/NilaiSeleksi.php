<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NilaiSeleksi extends Model
{
    use HasFactory;

    protected $table = 'nilai_seleksi';
    protected $primaryKey = 'id_nilai';

    protected $fillable = [
        'id_calon_siswa',
        'id_komponen_seleksi',
        'nilai',
        'catatan',
        'penguji_id',
    ];

    protected $casts = [
        'nilai' => 'decimal:2',
    ];

    public function calonSiswa(): BelongsTo
    {
        return $this->belongsTo(CalonSiswa::class, 'id_calon_siswa', 'id_calon_siswa');
    }

    public function komponenSeleksi(): BelongsTo
    {
        return $this->belongsTo(KomponenSeleksi::class, 'id_komponen_seleksi', 'id_komponen_seleksi');
    }

    public function penguji(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penguji_id');
    }
}
