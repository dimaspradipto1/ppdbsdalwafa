<?php

namespace Database\Seeders;

use App\Models\Jalur;
use App\Models\TahunAjaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JalurSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $ta = TahunAjaran::where('is_active', true)->first() ?? TahunAjaran::first();

        $daftarJalur = [
            [
                'id_tahun_ajaran'    => optional($ta)->id_tahun_ajaran,
                'nama_jalur'         => 'Jalur Reguler',
                'kode_jalur'         => 'REG',
                'kuota'              => 80,
                'deskripsi'          => 'Penerimaan peserta didik baru umum / reguler',
                'persyaratan_khusus' => null,
                'is_active'          => true,
            ],
            [
                'id_tahun_ajaran'    => optional($ta)->id_tahun_ajaran,
                'nama_jalur'         => 'Jalur Siswa Pindahan',
                'kode_jalur'         => 'PINDAHAN',
                'kuota'              => 15,
                'deskripsi'          => 'Penerimaan mutasi / siswa pindahan dari sekolah lain',
                'persyaratan_khusus' => 'Melampirkan surat pindah dan buku rapor sekolah asal',
                'is_active'          => true,
            ],
            [
                'id_tahun_ajaran'    => optional($ta)->id_tahun_ajaran,
                'nama_jalur'         => 'Jalur Prestasi & Tahfidz',
                'kode_jalur'         => 'PRESTASI',
                'kuota'              => 10,
                'deskripsi'          => 'Jalur prestasi akademik, non-akademik, atau hafalan Al-Qur\'an',
                'persyaratan_khusus' => 'Sertifikat kejuaraan minimal tingkat kota/kabupaten atau sertifikat tahfidz minimal 1 Juz',
                'is_active'          => true,
            ],
        ];

        foreach ($daftarJalur as $item) {
            Jalur::updateOrCreate(
                ['kode_jalur' => $item['kode_jalur']],
                $item
            );
        }
    }
}
