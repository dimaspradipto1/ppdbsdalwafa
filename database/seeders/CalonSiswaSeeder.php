<?php

namespace Database\Seeders;

use App\Models\Agama;
use App\Models\CalonSiswa;
use App\Models\KebutuhanKhusus;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Penghasilan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CalonSiswaSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agamaIslam = Agama::where('nama_agama', 'Islam')->first();
        $kebTidakAda = KebutuhanKhusus::where('kode', '01')->first();
        $kebCerdas = KebutuhanKhusus::where('kode', 'I')->first();

        $pekPns = Pekerjaan::where('nama_pekerjaan', 'like', '%PNS%')->first() ?? Pekerjaan::first();
        $pekSwasta = Pekerjaan::where('nama_pekerjaan', 'like', '%Karyawan Swasta%')->first() ?? Pekerjaan::first();
        $pekWira = Pekerjaan::where('nama_pekerjaan', 'like', '%Wiraswasta%')->first() ?? Pekerjaan::first();

        $penS1 = Pendidikan::where('nama_pendidikan', 'like', '%S1%')->first() ?? Pendidikan::first();
        $penSma = Pendidikan::where('nama_pendidikan', 'like', '%SMA%')->first() ?? Pendidikan::first();

        $penghasilanTinggi = Penghasilan::where('label', 'like', '%5.000.000%')->first() ?? Penghasilan::first();
        $penghasilanSedang = Penghasilan::where('label', 'like', '%2.000.000%')->first() ?? Penghasilan::first();

        // Contoh Calon Siswa 1
        $siswa1 = CalonSiswa::create([
            'nama_lengkap'           => 'Muhammad Fauzan Azhim',
            'jenis_kelamin'          => 'Laki-laki',
            'nik'                    => '2171011205180001',
            'nisn'                   => '3181234567',
            'tempat_lahir'           => 'Batam',
            'tanggal_lahir'          => '2018-05-12',
            'id_agama'               => $agamaIslam?->id_agama,
            'jumlah_saudara_kandung' => 2,
            'anak_ke'                => 1,
            'id_kebutuhan_khusus'    => $kebTidakAda?->id_kebutuhan,
            'alamat_jalan'           => 'Perumahan Graha Legenda Malaka Blok B3 No. 15',
            'rt'                     => '003',
            'rw'                     => '005',
            'kelurahan'              => 'Baloi Permai',
            'kode_pos'               => '29432',
            'kecamatan'              => 'Batam Kota',
            'kabupaten_kota'         => 'Kota Batam',
            'provinsi'               => 'Kepulauan Riau',
            'alat_transportasi'      => 'Sepeda Motor',
            'jenis_tinggal'          => 'Bersama Orangtua',
            'telepon_rumah'          => '0778-456789',
            'no_hp'                  => '081234567890',
            'jarak_ke_sekolah'       => 'kurang dari 1 km',
            'waktu_tempuh'           => 'kurang dari 30 menit',
            'email'                  => 'orangtua.fauzan@gmail.com',
            'asal_sekolah'           => 'TK Islam Terpadu Al-Wafa Batam',
            'nama_ayah'              => 'Ahmad Syarifuddin, S.T.',
            'tempat_lahir_ayah'      => 'Padang',
            'tanggal_lahir_ayah'     => '1988-03-15',
            'pekerjaan_ayah_id'      => $pekSwasta?->id_pekerjaan,
            'pendidikan_ayah_id'     => $penS1?->id_pendidikan,
            'agama_ayah_id'          => $agamaIslam?->id_agama,
            'penghasilan_ayah_id'    => $penghasilanTinggi?->id_penghasilan,
            'nama_ibu'               => 'Siti Fatimah, S.Pd.',
            'tempat_lahir_ibu'       => 'Medan',
            'tanggal_lahir_ibu'      => '1990-07-22',
            'pekerjaan_ibu_id'       => $pekPns?->id_pekerjaan,
            'pendidikan_ibu_id'      => $penS1?->id_pendidikan,
            'agama_ibu_id'           => $agamaIslam?->id_agama,
            'penghasilan_ibu_id'     => $penghasilanSedang?->id_penghasilan,
            'status'                 => 'menunggu_verifikasi',
        ]);

        // Prestasi Siswa 1
        $siswa1->prestasi()->createMany([
            [
                'jenis_prestasi' => '01. Sains',
                'tingkat'        => 'Kecamatan',
                'nama_prestasi'  => 'Juara 1 Lomba Berhitung Cepat Anak Usia Dini',
                'tahun'          => '2024',
                'penyelenggara'  => 'IGTKI Batam Kota',
            ],
            [
                'jenis_prestasi' => '02. Seni',
                'tingkat'        => 'Kab.Kota',
                'nama_prestasi'  => 'Juara 2 Lomba Hafalan Surat Pendek (Tahfidz Cilik)',
                'tahun'          => '2025',
                'penyelenggara'  => 'Kemenag Kota Batam',
            ],
        ]);

        // Beasiswa Siswa 1
        $siswa1->beasiswa()->create([
            'jenis_beasiswa' => 'Beasiswa Prestasi Tahfidz Quran',
            'penyelenggara'  => 'Yayasan Daarul Aitam Batam',
            'tahun_mulai'    => '2024',
            'tahun_selesai'  => '2025',
        ]);

        // Contoh Calon Siswa 2
        $siswa2 = CalonSiswa::create([
            'nama_lengkap'           => 'Aisyah Putri Rahmadani',
            'jenis_kelamin'          => 'Perempuan',
            'nik'                    => '2171025508180002',
            'nisn'                   => '3189876543',
            'tempat_lahir'           => 'Tanjung Pinang',
            'tanggal_lahir'          => '2018-08-15',
            'id_agama'               => $agamaIslam?->id_agama,
            'jumlah_saudara_kandung' => 1,
            'anak_ke'                => 2,
            'id_kebutuhan_khusus'    => $kebCerdas?->id_kebutuhan ?? $kebTidakAda?->id_kebutuhan,
            'alamat_jalan'           => 'Komp. Bunga Raya Garden Blok A No. 7',
            'rt'                     => '002',
            'rw'                     => '004',
            'kelurahan'              => 'Belian',
            'kode_pos'               => '29464',
            'kecamatan'              => 'Batam Kota',
            'kabupaten_kota'         => 'Kota Batam',
            'provinsi'               => 'Kepulauan Riau',
            'alat_transportasi'      => 'Mobil Pribadi',
            'jenis_tinggal'          => 'Bersama Orangtua',
            'no_hp'                  => '082198765432',
            'jarak_ke_sekolah'       => 'lebih dari 1 km',
            'jarak_ke_sekolah_detail'=> '2.5 km',
            'waktu_tempuh'           => 'kurang dari 30 menit',
            'email'                  => 'putri.aisyah@gmail.com',
            'asal_sekolah'           => 'TK Pertiwi Batam',
            'nama_ayah'              => 'Budi Rahmanto, S.E.',
            'tempat_lahir_ayah'      => 'Jakarta',
            'tanggal_lahir_ayah'     => '1985-11-10',
            'pekerjaan_ayah_id'      => $pekWira?->id_pekerjaan,
            'pendidikan_ayah_id'     => $penS1?->id_pendidikan,
            'agama_ayah_id'          => $agamaIslam?->id_agama,
            'penghasilan_ayah_id'    => $penghasilanTinggi?->id_penghasilan,
            'nama_ibu'               => 'Nurul Hidayah',
            'tempat_lahir_ibu'       => 'Bandung',
            'tanggal_lahir_ibu'      => '1987-09-18',
            'pekerjaan_ibu_id'       => $pekSwasta?->id_pekerjaan,
            'pendidikan_ibu_id'      => $penSma?->id_pendidikan,
            'agama_ibu_id'           => $agamaIslam?->id_agama,
            'penghasilan_ibu_id'     => $penghasilanSedang?->id_penghasilan,
            'status'                 => 'diverifikasi',
        ]);

        // Prestasi Siswa 2
        $siswa2->prestasi()->create([
            'jenis_prestasi' => '02. Seni',
            'tingkat'        => 'Propinsi',
            'nama_prestasi'  => 'Juara Harapan 1 Lomba Mewarnai & Menggambar Kaligrafi',
            'tahun'          => '2024',
            'penyelenggara'  => 'Dinas Kebudayaan Provinsi Kepri',
        ]);
    }
}
