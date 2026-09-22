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
        'no_pendaftaran',
        'user_id',
        'id_tahun_ajaran',
        'id_gelombang',
        'id_jalur',
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
        'tanggal_daftar',
        'catatan_verifikasi',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'tanggal_lahir'          => 'date',
        'tanggal_lahir_ayah'     => 'date',
        'tanggal_lahir_ibu'      => 'date',
        'tanggal_lahir_wali'     => 'date',
        'tanggal_daftar'         => 'datetime',
        'verified_at'            => 'datetime',
        'jumlah_saudara_kandung' => 'integer',
        'anak_ke'                => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->no_pendaftaran)) {
                $model->no_pendaftaran = static::generateNoPendaftaran($model->id_tahun_ajaran);
            }
            if (empty($model->tanggal_daftar)) {
                $model->tanggal_daftar = now();
            }
        });
    }

    public static function generateNoPendaftaran(?int $idTahunAjaran = null): string
    {
        $tahun = date('Y');
        if ($idTahunAjaran) {
            $ta = TahunAjaran::find($idTahunAjaran);
            if ($ta && preg_match('/^(\d{4})/', $ta->tahun_ajaran, $matches)) {
                $tahun = $matches[1];
            }
        }

        $last = static::where('no_pendaftaran', 'LIKE', "REG-{$tahun}-%")
            ->orderByDesc('id_calon_siswa')
            ->first();

        $nextNum = 1;
        if ($last && $last->no_pendaftaran && preg_match('/REG-\d{4}-(\d+)/', $last->no_pendaftaran, $matches)) {
            $nextNum = (int)$matches[1] + 1;
        } else {
            $count = static::whereYear('created_at', $tahun)->count();
            $nextNum = $count + 1;
        }

        return sprintf('REG-%s-%04d', $tahun, $nextNum);
    }

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

    public function dokumen(): HasMany
    {
        return $this->hasMany(DokumenSiswa::class, 'id_calon_siswa', 'id_calon_siswa');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

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

    public function verifiedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
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
