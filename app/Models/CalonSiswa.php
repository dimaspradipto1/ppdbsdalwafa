<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CalonSiswa extends Model
{
    use HasFactory;

    protected $table = 'calon_siswa';

    protected $primaryKey = 'id_calon_siswa';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'jenis_kelamin',
        'nik',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'id_agama',
        'jumlah_saudara_kandung',
        'anak_ke',
        'id_kebutuhan_khusus',
        'alamat_jalan',
        'rt',
        'rw',
        'kelurahan',
        'kode_pos',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'alat_transportasi',
        'jenis_tinggal',
        'telepon_rumah',
        'no_hp',
        'jarak_ke_sekolah',
        'jarak_ke_sekolah_detail',
        'waktu_tempuh',
        'email',
        'asal_sekolah',
        'nama_ayah',
        'tempat_lahir_ayah',
        'tanggal_lahir_ayah',
        'pekerjaan_ayah_id',
        'pendidikan_ayah_id',
        'agama_ayah_id',
        'penghasilan_ayah_id',
        'nama_ibu',
        'tempat_lahir_ibu',
        'tanggal_lahir_ibu',
        'pekerjaan_ibu_id',
        'pendidikan_ibu_id',
        'agama_ibu_id',
        'penghasilan_ibu_id',
        'nama_wali',
        'tempat_lahir_wali',
        'tanggal_lahir_wali',
        'pekerjaan_wali_id',
        'pendidikan_wali_id',
        'agama_wali_id',
        'penghasilan_wali_id',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir'      => 'date',
        'tanggal_lahir_ayah' => 'date',
        'tanggal_lahir_ibu'  => 'date',
        'tanggal_lahir_wali' => 'date',
        'jumlah_saudara_kandung' => 'integer',
        'anak_ke'            => 'integer',
    ];

    // ==========================================
    // RELASI HAS MANY (Prestasi & Beasiswa)
    // ==========================================

    public function prestasi(): HasMany
    {
        return $this->hasMany(Prestasi::class, 'id_calon_siswa', 'id_calon_siswa');
    }

    public function beasiswa(): HasMany
    {
        return $this->hasMany(Beasiswa::class, 'id_calon_siswa', 'id_calon_siswa');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ==========================================
    // RELASI MASTER DATA SISWA
    // ==========================================

    public function agama(): BelongsTo
    {
        return $this->belongsTo(Agama::class, 'id_agama', 'id_agama');
    }

    public function kebutuhanKhusus(): BelongsTo
    {
        return $this->belongsTo(KebutuhanKhusus::class, 'id_kebutuhan_khusus', 'id_kebutuhan');
    }

    // ==========================================
    // RELASI ORANG TUA / WALI
    // ==========================================

    public function pekerjaanAyah(): BelongsTo
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_ayah_id', 'id_pekerjaan');
    }

    public function pendidikanAyah(): BelongsTo
    {
        return $this->belongsTo(Pendidikan::class, 'pendidikan_ayah_id', 'id_pendidikan');
    }

    public function agamaAyah(): BelongsTo
    {
        return $this->belongsTo(Agama::class, 'agama_ayah_id', 'id_agama');
    }

    public function penghasilanAyah(): BelongsTo
    {
        return $this->belongsTo(Penghasilan::class, 'penghasilan_ayah_id', 'id_penghasilan');
    }

    public function pekerjaanIbu(): BelongsTo
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_ibu_id', 'id_pekerjaan');
    }

    public function pendidikanIbu(): BelongsTo
    {
        return $this->belongsTo(Pendidikan::class, 'pendidikan_ibu_id', 'id_pendidikan');
    }

    public function agamaIbu(): BelongsTo
    {
        return $this->belongsTo(Agama::class, 'agama_ibu_id', 'id_agama');
    }

    public function penghasilanIbu(): BelongsTo
    {
        return $this->belongsTo(Penghasilan::class, 'penghasilan_ibu_id', 'id_penghasilan');
    }

    public function pekerjaanWali(): BelongsTo
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_wali_id', 'id_pekerjaan');
    }

    public function pendidikanWali(): BelongsTo
    {
        return $this->belongsTo(Pendidikan::class, 'pendidikan_wali_id', 'id_pendidikan');
    }

    public function agamaWali(): BelongsTo
    {
        return $this->belongsTo(Agama::class, 'agama_wali_id', 'id_agama');
    }

    public function penghasilanWali(): BelongsTo
    {
        return $this->belongsTo(Penghasilan::class, 'penghasilan_wali_id', 'id_penghasilan');
    }
}
