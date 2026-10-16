<?php

namespace Database\Seeders;

use App\Models\JenisDokumen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisDokumenSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $persyaratanDokumen = [
            // ==========================================
            // PERSYARATAN SISWA BARU
            // ==========================================
            [
                'kode'          => 'AKTA_KK',
                'nama_dokumen'  => 'Akta Kelahiran & Kartu Keluarga (KK)',
                'kategori'      => 'siswa_baru',
                'jumlah_lembar' => null,
                'keterangan'    => 'File scan / foto jelas Akta Kelahiran dan Kartu Keluarga calon siswa',
                'is_wajib'      => true,
                'is_active'     => true,
            ],
            [
                'kode'          => 'KTP_ORTU',
                'nama_dokumen'  => 'KTP Orang Tua (Ayah & Ibu)',
                'kategori'      => 'siswa_baru',
                'jumlah_lembar' => null,
                'keterangan'    => 'File scan / foto jelas e-KTP Ayah dan e-KTP Ibu (atau Wali)',
                'is_wajib'      => true,
                'is_active'     => true,
            ],
            [
                'kode'          => 'PAS_FOTO',
                'nama_dokumen'  => 'Pas Foto Berwarna (3 x 4)',
                'kategori'      => 'siswa_baru',
                'jumlah_lembar' => null,
                'keterangan'    => 'Pas foto formal berseragam putih latar belakang merah',
                'is_wajib'      => true,
                'is_active'     => true,
            ],
            [
                'kode'          => 'HADIR_SISWA',
                'nama_dokumen'  => 'Formulir Pernyataan Kehadiran Siswa',
                'kategori'      => 'siswa_baru',
                'jumlah_lembar' => null,
                'keterangan'    => 'Konfirmasi kesiapan menghadirkan calon siswa pada saat observasi di sekolah',
                'is_wajib'      => true,
                'is_active'     => true,
            ],

            // ==========================================
            // PERSYARATAN SISWA PINDAHAN
            // ==========================================
            [
                'kode'          => 'SURAT_PINDAH',
                'nama_dokumen'  => 'Surat Pindah dari Sekolah Asal',
                'kategori'      => 'siswa_pindahan',
                'jumlah_lembar' => null,
                'keterangan'    => 'File scan / foto Surat keterangan pindah resmi dari sekolah asal',
                'is_wajib'      => true,
                'is_active'     => true,
            ],
            [
                'kode'          => 'BUKU_RAPOR',
                'nama_dokumen'  => 'Buku Rapor Lengkap dari Sekolah Asal',
                'kategori'      => 'siswa_pindahan',
                'jumlah_lembar' => null,
                'keterangan'    => 'File scan rapor semester terakhir lengkap dengan tanda tangan kepala sekolah',
                'is_wajib'      => true,
                'is_active'     => true,
            ],
        ];

        foreach ($persyaratanDokumen as $item) {
            JenisDokumen::updateOrCreate(
                ['kode' => $item['kode']],
                [
                    'nama_dokumen'  => $item['nama_dokumen'],
                    'kategori'      => $item['kategori'],
                    'jumlah_lembar' => $item['jumlah_lembar'],
                    'keterangan'    => $item['keterangan'],
                    'is_wajib'      => $item['is_wajib'],
                    'is_active'     => $item['is_active'],
                ]
            );
        }

        // Buat contoh dokumen terunggah jika ada calon siswa
        $siswa1 = \App\Models\CalonSiswa::first();
        $dokAkta = JenisDokumen::where('kode', 'AKTA_KK')->first();
        $dokFoto = JenisDokumen::where('kode', 'PAS_FOTO')->first();

        if ($siswa1 && $dokAkta) {
            \App\Models\DokumenSiswa::updateOrCreate(
                [
                    'id_calon_siswa'   => $siswa1->id_calon_siswa,
                    'id_jenis_dokumen' => $dokAkta->id_jenis_dokumen,
                ],
                [
                    'nama_file'          => 'akta_kelahiran_fauzan.pdf',
                    'file_path'          => 'dokumen/sample_akta_kelahiran.pdf',
                    'tipe_file'          => 'pdf',
                    'ukuran_file'        => 245,
                    'status_verifikasi'  => 'valid',
                    'catatan_verifikasi' => 'Berkas fotocopy akta kelahiran 3 lembar lengkap & jelas',
                    'verified_at'        => now(),
                ]
            );
        }

        if ($siswa1 && $dokFoto) {
            \App\Models\DokumenSiswa::updateOrCreate(
                [
                    'id_calon_siswa'   => $siswa1->id_calon_siswa,
                    'id_jenis_dokumen' => $dokFoto->id_jenis_dokumen,
                ],
                [
                    'nama_file'          => 'pas_foto_3x4_fauzan.pdf',
                    'file_path'          => 'dokumen/sample_akta_kelahiran.pdf',
                    'tipe_file'          => 'pdf',
                    'ukuran_file'        => 180,
                    'status_verifikasi'  => 'menunggu',
                    'catatan_verifikasi' => 'Menunggu verifikasi fisik latar belakang merah seragam SD',
                ]
            );
        }
    }
}
