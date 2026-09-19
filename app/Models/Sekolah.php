<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = 'sekolah';

    protected $primaryKey = 'id_sekolah';

    protected $fillable = [
        'npsn',
        'nama_sekolah',
        'jenjang',
        'status_sekolah',
        'nama_yayasan',
        'alamat',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'kode_pos',
        'telepon',
        'email',
        'website',
        'logo_path',
        'latitude',
        'longitude',
    ];

    /**
     * Jenjang sekolah yang didukung
     */
    public const JENJANG = [
        'PAUD' => 'Pendidikan Anak Usia Dini (PAUD)',
        'TK'   => 'Taman Kanak-Kanak (TK)',
        'SD'   => 'Sekolah Dasar (SD)',
        'SMP'  => 'Sekolah Menengah Pertama (SMP)',
        'SMA'  => 'Sekolah Menengah Atas (SMA)',
        'SMK'  => 'Sekolah Menengah Kejuruan (SMK)',
    ];

    /**
     * Status sekolah
     */
    public const STATUS = [
        'Swasta' => 'Swasta',
        'Negeri' => 'Negeri',
    ];

    /**
     * Helper URL logo sekolah
     */
    public function getLogoUrlAttribute(): string
    {
        if ($this->logo_path && file_exists(public_path($this->logo_path))) {
            return asset($this->logo_path);
        }

        return asset('assets/img/cropped-lodo-sdip-alwafa.webp');
    }
}
