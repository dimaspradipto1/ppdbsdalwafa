<?php

namespace Database\Seeders;

use App\Models\Pekerjaan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PekerjaanSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftarPekerjaan = [
            [
                'nama_pekerjaan' => 'PNS / ASN',
                'keterangan'     => 'Pegawai Negeri Sipil / Aparatur Sipil Negara',
                'is_active'      => true,
            ],
            [
                'nama_pekerjaan' => 'TNI / Polri',
                'keterangan'     => 'Tentara Nasional Indonesia / Kepolisian RI',
                'is_active'      => true,
            ],
            [
                'nama_pekerjaan' => 'Karyawan Swasta',
                'keterangan'     => 'Pegawai / Karyawan Perusahaan Swasta',
                'is_active'      => true,
            ],
            [
                'nama_pekerjaan' => 'Karyawan BUMN / BUMD',
                'keterangan'     => 'Pegawai Badan Usaha Milik Negara / Daerah',
                'is_active'      => true,
            ],
            [
                'nama_pekerjaan' => 'Wiraswasta / Pedagang',
                'keterangan'     => 'Pengusaha / Pedagang / Pemilik Usaha Sendiri',
                'is_active'      => true,
            ],
            [
                'nama_pekerjaan' => 'Petani / Peternak',
                'keterangan'     => 'Sektor Pertanian / Peternakan',
                'is_active'      => true,
            ],
            [
                'nama_pekerjaan' => 'Nelayan',
                'keterangan'     => 'Sektor Kelautan dan Perikanan',
                'is_active'      => true,
            ],
            [
                'nama_pekerjaan' => 'Buruh Harian / Lepas',
                'keterangan'     => 'Pekerja Harian Lepas / Buruh Pabrik',
                'is_active'      => true,
            ],
            [
                'nama_pekerjaan' => 'Guru / Dosen',
                'keterangan'     => 'Pendidik / Tenaga Pengajar',
                'is_active'      => true,
            ],
            [
                'nama_pekerjaan' => 'Dokter / Tenaga Medis',
                'keterangan'     => 'Dokter / Bidan / Perawat / Tenaga Kesehatan',
                'is_active'      => true,
            ],
            [
                'nama_pekerjaan' => 'Ibu Rumah Tangga',
                'keterangan'     => 'Mengurus Rumah Tangga',
                'is_active'      => true,
            ],
            [
                'nama_pekerjaan' => 'Pensiunan',
                'keterangan'     => 'Purnawirawan / Pensiunan',
                'is_active'      => true,
            ],
            [
                'nama_pekerjaan' => 'Tidak / Belum Bekerja',
                'keterangan'     => 'Sedang mencari kerja / belum bekerja',
                'is_active'      => true,
            ],
            [
                'nama_pekerjaan' => 'Lainnya',
                'keterangan'     => 'Pekerjaan atau profesi lainnya',
                'is_active'      => true,
            ],
        ];

        foreach ($daftarPekerjaan as $item) {
            Pekerjaan::updateOrCreate(
                ['nama_pekerjaan' => $item['nama_pekerjaan']],
                [
                    'keterangan' => $item['keterangan'],
                    'is_active'  => $item['is_active'],
                ]
            );
        }
    }
}
