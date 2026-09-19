<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SekolahSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sekolah::updateOrCreate(
            ['npsn' => '69888848'],
            [
                'nama_sekolah'   => 'SD Islam Plus Al-Wafa',
                'jenjang'        => 'SD',
                'status_sekolah' => 'Swasta',
                'nama_yayasan'   => 'Yayasan Daarul Aitam Batam (YDAB)',
                'alamat'         => 'Perumahan Bida Asri 2 Blok G2 No. 10-15',
                'desa_kelurahan' => 'Belian',
                'kecamatan'      => 'Batam Kota',
                'kabupaten_kota' => 'Kota Batam',
                'provinsi'       => 'Kepulauan Riau',
                'kode_pos'       => '29464',
                'telepon'        => '082323222606',
                'email'          => 'sdipalwafa@gmail.com',
                'website'        => 'https://alwafaislamicschool.com',
                'logo_path'      => 'assets/img/cropped-lodo-sdip-alwafa.webp',
                'latitude'       => 1.11860000,
                'longitude'      => 104.05310000,
            ]
        );
    }
}
