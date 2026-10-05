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
                $model->no_pendaftaran = static::generateNoPendaftaran($model->id_tahun_ajaran, $model->id_gelombang);
            }
            if (empty($model->tanggal_daftar)) {
                $model->tanggal_daftar = now();
            }
        });

        static::saving(function ($model) {
            if (empty($model->no_pendaftaran)) {
                $model->no_pendaftaran = static::generateNoPendaftaran($model->id_tahun_ajaran, $model->id_gelombang);
            }
        });
    }

    /**
     * Generate Nomor Registrasi Pendaftaran Siswa (Nomor Murni, Tanpa REG & Tanpa Tanda Hubung)
     * Format Standar Numerik Sekolah: [TAHUN][NOMOR_URUT_4_DIGIT]
     * Contoh: 20260001, 20260002, 20260003
     */
    public static function generateNoPendaftaran(?int $idTahunAjaran = null, ?int $idGelombang = null): string
    {
        // 1. Tentukan Tahun Ajaran (misal 2026 dari '2026/2027')
        $tahun = date('Y');
        if ($idTahunAjaran) {
            $ta = TahunAjaran::find($idTahunAjaran);
            if ($ta && preg_match('/^(\d{4})/', $ta->tahun_ajaran, $matches)) {
                $tahun = $matches[1];
            }
        } else {
            $taAktif = TahunAjaran::where('is_active', true)->first();
            if ($taAktif && preg_match('/^(\d{4})/', $taAktif->tahun_ajaran, $matches)) {
                $tahun = $matches[1];
            }
        }

        $prefix = (string)$tahun;

        // 2. Cari nomor urut numerik tertinggi yang sudah terdaftar untuk tahun ini
        $allRegistrations = static::where('no_pendaftaran', 'LIKE', "{$prefix}%")
            ->pluck('no_pendaftaran');

        $maxNumber = 0;
        foreach ($allRegistrations as $reg) {
            if (preg_match('/^' . $tahun . '(\d{4})$/', $reg, $m)) {
                $val = (int)$m[1];
                if ($val > $maxNumber) {
                    $maxNumber = $val;
                }
            } elseif (preg_match('/REG-?\d{4}-?(\d+)/i', $reg, $m)) {
                $val = (int)$m[1];
                if ($val > $maxNumber) {
                    $maxNumber = $val;
                }
            }
        }

        $nextNum = $maxNumber + 1;

        // 3. Verifikasi Keunikan Secara Mutlak (Loop Anti-Collision)
        do {
            $generatedNo = sprintf('%s%04d', $prefix, $nextNum);
            $exists = static::where('no_pendaftaran', $generatedNo)->exists();
            if ($exists) {
                $nextNum++;
            }
        } while ($exists);

        return $generatedNo;
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

    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'id_calon_siswa', 'id_calon_siswa');
    }

    public function nilaiSeleksi(): HasMany
    {
        return $this->hasMany(NilaiSeleksi::class, 'id_calon_siswa', 'id_calon_siswa');
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
