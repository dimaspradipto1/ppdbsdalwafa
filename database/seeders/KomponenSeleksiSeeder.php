<?php

namespace Database\Seeders;

use App\Models\KomponenSeleksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KomponenSeleksiSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $daftarKomponen = [
            [
                'nama_komponen' => 'Observasi Kesiapan Belajar & Motorik',
                'kode'          => 'OBS_BELAJAR',
                'nilai_minimal' => 70.00,
                'bobot_persen'  => 35,
                'urutan'        => 1,
                'keterangan'    => 'Pengamatan interaksi sosial, kemandirian, motorik halus/kasar, serta pengenalan dasar warna/angka/huruf',
                'is_active'     => true,
            ],
            [
                'nama_komponen' => 'Tes Baca Al-Qur\'an / Iqro & Hafalan Surat Pendek',
                'kode'          => 'TAHFIDZ_IQRO',
                'nilai_minimal' => 70.00,
                'bobot_persen'  => 35,
                'urutan'        => 2,
                'keterangan'    => 'Pengujian kemampuan mengenal huruf hijaiyah/Iqro serta hafalan doa harian dan surat-surat pendek Juz Amma',
                'is_active'     => true,
            ],
            [
                'nama_komponen' => 'Wawancara Komitmen Orang Tua / Wali Siswa',
                'kode'          => 'WAWANCARA_ORTU',
                'nilai_minimal' => 75.00,
                'bobot_persen'  => 30,
                'urutan'        => 3,
                'keterangan'    => 'Wawancara keselarasan visi pendidikan Islam, tata tertib sekolah, dan komitmen pendampingan belajar di rumah',
                'is_active'     => true,
            ],
        ];

        foreach ($daftarKomponen as $item) {
            KomponenSeleksi::updateOrCreate(
                ['kode' => $item['kode']],
                $item
            );
        }
    }
}
