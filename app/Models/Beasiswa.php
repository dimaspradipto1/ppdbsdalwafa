<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Beasiswa extends Model
{
    use HasFactory;

    protected $table = 'beasiswa';

    protected $primaryKey = 'id_beasiswa';

    protected $fillable = [
        'id_calon_siswa',
        'jenis_beasiswa',
        'penyelenggara',
        'tahun_mulai',
        'tahun_selesai',
    ];

    public function calonSiswa(): BelongsTo
    {
        return $this->belongsTo(CalonSiswa::class, 'id_calon_siswa', 'id_calon_siswa');
    }
}
