<?php

namespace Database\Seeders;

use App\Models\Gelombang;
use App\Models\Pengumuman;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Database\Seeder;

class PengumumanSeeder extends Seeder
{
    public function run(): void
    {
        $ta = TahunAjaran::where('tahun_ajaran', '2026/2027')->first() ?? TahunAjaran::first();
        $gel = Gelombang::first();
        $admin = User::whereIn('role', ['super_admin', 'admin_ppdb'])->first();

        $items = [
            [
                'judul' => 'PENGUMUMAN PELAKSANAAN OBSERVASI KEMATANGAN & TAHFIDZ AL-QUR\'AN TP 2026/2027',
                'nomor_surat' => '042/PPDB-SDIP/VII/2026',
                'tanggal_buka' => '2026-07-30 08:00:00',
                'isi_pengumuman' => "Assalamu’alaikum Warahmatullahi Wabarakatuh.\n\nDiberitahukan kepada seluruh calon wali murid yang telah mendaftar pada Penerimaan Peserta Didik Baru (PPDB) SD Islam Plus Al-Wafa Batam bahwa kegiatan Observasi Kematangan Calon Siswa dan Tes Kemampuan Dasar Tahfidz Al-Qur'an (Surat Pendek / Iqro) akan dilaksanakan secara bertahap.\n\nDetail Pelaksanaan Kegiatan:\n1. Jadwal Observasi: 05 s/d 08 Agustus 2026\n2. Waktu: Pukul 08.00 - 11.30 WIB (dibagi per kloter sesi)\n3. Lokasi: Gedung Utama SD Islam Plus Al-Wafa Batam, Komplek Bida Asri II Blok G2 No. 11-15 Batam Kota\n4. Perlengkapan Calon Siswa: Membawa kartu bukti pendaftaran online dan alat tulis pensil 2B\n5. Pakaian: Berbusana muslim / muslimah rapi dan bersepatu.\n\nOrang tua diwajibkan mendampingi ananda dan menghadiri sesi ramah tamah bersama kepala sekolah serta guru penguji. Mohon hadir 15 menit sebelum sesi dimulai.\n\nDemikian pengumuman ini kami sampaikan. Atas perhatian dan kerja sama Bapak/Ibu sekalian, kami ucapkan terima kasih.\n\nWassalamu’alaikum Warahmatullahi Wabarakatuh.",
                'is_published' => true,
            ],
            [
                'judul' => 'PENGUMUMAN JADWAL GELOMBANG 1 PPDB SD ISLAM PLUS AL-WAFA BATAM TP 2026/2027',
                'nomor_surat' => '038/PPDB-SDIP/VII/2026',
                'tanggal_buka' => '2026-07-21 08:00:00',
                'isi_pengumuman' => "Assalamu’alaikum Warahmatullahi Wabarakatuh.\n\nPendaftaran Peserta Didik Baru (PPDB) Gelombang 1 SD Islam Plus Al-Wafa Batam Tahun Pelajaran 2026/2027 resmi dibuka secara daring (online) dan luring (offline).\n\nKeuntungan Khusus Gelombang 1:\n• Prioritas alokasi penempatan rombongan belajar kelas tematik Sahabat Nabi (Rombel Abu Bakar Ash-Shiddiq, Umar bin Khotthob, dan Utsman bin Affan).\n• Bebas biaya formulir pendaftaran khusus bagi pendaftar awal.\n• Kemudahan skema cicilan biaya perlengkapan dan seragam sekolah hingga 3 kali angsuran.\n\nTata Cara Pendaftaran:\n1. Klik tombol 'Daftar Akun' pada website resmi ini.\n2. Lengkapi identitas calon siswa dan data orang tua/wali.\n3. Unggah scan Kartu Keluarga, Akta Kelahiran, dan Pas Foto terbaru.\n4. Konfirmasi pembayaran formulir pendaftaran.\n\nPosko layanan informasi PPDB di kampus sekolah buka setiap hari kerja Senin - Sabtu pukul 07.30 - 15.00 WIB.\n\nWassalamu’alaikum Warahmatullahi Wabarakatuh.",
                'is_published' => true,
            ],
            [
                'judul' => 'PENGUMUMAN HASIL OBSERVASI UNTUK CALON SISWA BARU TP 2026/2027',
                'nomor_surat' => '025/PPDB-SDIP/IV/2026',
                'tanggal_buka' => '2026-04-25 09:00:00',
                'isi_pengumuman' => "Assalamu’alaikum Warahmatullahi Wabarakatuh.\n\nBerdasarkan hasil sidang pleno Dewan Guru dan Panitia Seleksi Penerimaan Peserta Didik Baru (PPDB) SD Islam Plus Al-Wafa Batam, berikut kami umumkan bahwa keputusan kelulusan observasi kematangan dan wawancara orang tua telah diterbitkan secara resmi.\n\nPetunjuk Bagi Calon Wali Murid:\n1. Silakan login ke akun wali murid melalui portal PPDB ini untuk melihat Surat Keputusan Kelulusan resmi.\n2. Bagi calon siswa yang dinyatakan DITERIMA, batas akhir daftar ulang dan konfirmasi penempatan kelas adalah 14 hari kerja setelah pengumuman ini diterbitkan.\n3. Pengambilan seragam sekolah dan buku paket akan diinformasikan lebih lanjut oleh bagian kesiswaan.\n\nSelamat atas kelulusan putra/putri Bapak/Ibu tercinta. Mari bersama kita bina ananda menjadi generasi pembelajar Qur'ani yang berakhlak mulia.\n\nWassalamu’alaikum Warahmatullahi Wabarakatuh.",
                'is_published' => true,
            ],
            [
                'judul' => 'RINCIAN BIAYA PENDIDIKAN & PERLENGKAPAN TAHUN 2026/2027',
                'nomor_surat' => '010/INFO-BIAYA/II/2026',
                'tanggal_buka' => '2026-02-04 10:00:00',
                'isi_pengumuman' => "Assalamu’alaikum Warahmatullahi Wabarakatuh.\n\nBerikut kami sampaikan rincian resmi pembiayaan pendidikan peserta didik baru SD Islam Plus Al-Wafa Batam Tahun Pelajaran 2026/2027 sebagai pedoman bagi para calon wali murid:\n\n1. Biaya Pendaftaran & Observasi: Rp. 250.000,- (Satu kali di awal)\n2. Uang Pangkal / Sarana Pembelajaran: Termasuk ruang kelas full AC, proyektor smart class, sanitasi bersih, dan fasilitas tahfidz corner.\n3. Seragam Sekolah (5 Stel Lengkap): Putih Merah, Batik Ciri Khas SD Al-Wafa, Baju Kurung Melayu Batam, Seragam Pramuka, dan Pakaian Olahraga.\n4. Buku Paket Tematik & Modul Diniyah / Tahsin untuk 1 Tahun Ajaran Penuh.\n5. SPP Bulanan: Mencakup kurikulum terpadu nasional, program tahfidz 2 juz, pembelajaran bahasa Arab/Inggris dasar, serta pembinaan akhlak harian.\n\nSkema Pembayaran Fleksibel:\nSekolah memfasilitasi opsi pembayaran bertahap (angsuran) hingga 3 kali pembayaran tanpa bunga untuk memudahkan bapak/ibu wali murid. Untuk konsultasi pembiayaan secara langsung, silakan hubungi bagian bendahara melalui WhatsApp panitia yang tertera di website.\n\nWassalamu’alaikum Warahmatullahi Wabarakatuh.",
                'is_published' => true,
            ],
        ];

        foreach ($items as $item) {
            Pengumuman::updateOrCreate(
                ['judul' => $item['judul']],
                [
                    'id_tahun_ajaran' => $ta ? $ta->id_tahun_ajaran : null,
                    'id_gelombang'    => $gel ? $gel->id_gelombang : null,
                    'nomor_surat'     => $item['nomor_surat'],
                    'tanggal_buka'    => $item['tanggal_buka'],
                    'isi_pengumuman'  => $item['isi_pengumuman'],
                    'is_published'    => $item['is_published'],
                    'created_by'      => $admin ? $admin->id : null,
                ]
            );
        }
    }
}
