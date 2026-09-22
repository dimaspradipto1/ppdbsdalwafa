<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomponenSeleksi extends Model
{
    use HasFactory;

    protected $table = 'komponen_seleksi';

    protected $primaryKey = 'id_komponen_seleksi';

    protected $fillable = [
        'nama_komponen',
        'kode',
        'nilai_minimal',
        'bobot_persen',
        'urutan',
        'keterangan',
        'is_active',
    ];

    protected $casts = [
        'nilai_minimal' => 'decimal:2',
        'bobot_persen'  => 'integer',
        'urutan'        => 'integer',
        'is_active'     => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
