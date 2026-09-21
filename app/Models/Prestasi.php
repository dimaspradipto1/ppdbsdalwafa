<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prestasi extends Model
{
    use HasFactory;

    protected $table = 'prestasi';

    protected $primaryKey = 'id_prestasi';

    protected $fillable = [
        'id_calon_siswa',
        'jenis_prestasi',
        'tingkat',
        'nama_prestasi',
        'tahun',
        'penyelenggara',
    ];

    public const JENIS_PRESTASI = [
        '01. Sains'     => '01. Sains',
        '02. Seni'      => '02. Seni',
        '03. Olahraga'  => '03. Olahraga',
        '04. Lain-lain' => '04. Lain-lain',
    ];

    public const TINGKAT = [
        'Sekolah'       => 'Sekolah',
        'Kecamatan'     => 'Kecamatan',
        'Kab.Kota'      => 'Kabupaten / Kota',
        'Propinsi'      => 'Propinsi / Provinsi',
        'Nasional'      => 'Nasional',
        'Internasional' => 'Internasional',
    ];

    public function calonSiswa(): BelongsTo
    {
        return $this->belongsTo(CalonSiswa::class, 'id_calon_siswa', 'id_calon_siswa');
    }
}
