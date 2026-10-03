<?php

namespace Database\Seeders;

use App\Models\HomepageBanner;
use App\Models\HomepageSetting;
use Illuminate\Database\Seeder;

class HomepageSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Banners
        if (HomepageBanner::count() === 0) {
            HomepageBanner::create([
                'judul' => "Membentuk Generasi Qur'ani, Berakhlak Mulia & Berwawasan Global",
                'subjudul' => 'Penerimaan Peserta Didik Baru (PPDB) Tahun Pelajaran 2026/2027 SD Islam Plus Al-Wafa Batam. Pilihan tepat untuk pendidikan islami, tahfidz Al-Qur\'an, dan keilmuan modern anak Anda.',
                'badge_text' => 'Penerimaan Peserta Didik Baru (PPDB) 2026/2027',
                'gambar' => 'assets/img/school-banner.jpg',
                'tombol_text_1' => 'Daftar Sekarang',
                'tombol_link_1' => '/register',
                'tombol_text_2' => 'Alur & Informasi Biaya',
                'tombol_link_2' => '#alur',
                'urutan' => 1,
                'is_active' => true,
            ]);

            HomepageBanner::create([
                'judul' => 'Pendidikan Islam Terpadu & Berkarakter Sahabat Nabi',
                'subjudul' => 'Kurikulum nasional diperkaya nilai-nilai Islam, pembiasaan adab harian, kelas digital interaktif, dan lingkungan belajar yang asri serta kondusif di Batam Kota.',
                'badge_text' => 'Keunggulan SD Islam Plus Al-Wafa',
                'gambar' => 'assets/img/school-banner.jpg',
                'tombol_text_1' => 'Lihat Visi Misi',
                'tombol_link_1' => '#visimisi',
                'tombol_text_2' => 'Kontak Panitia PPDB',
                'tombol_link_2' => '#kontak',
                'urutan' => 2,
                'is_active' => true,
            ]);
        }

        // 2. Seed Homepage Settings
        $settings = [
            // Sambutan & Kepala Sekolah
            ['key' => 'sambutan_nama', 'value' => 'Ririn Kartika Sari Dalimunthe, S.Pd.I', 'group' => 'sambutan', 'label' => 'Nama Kepala Sekolah'],
            ['key' => 'sambutan_jabatan', 'value' => 'Kepala Sekolah SD Islam Plus Al-Wafa Batam', 'group' => 'sambutan', 'label' => 'Jabatan'],
            ['key' => 'sambutan_nuptk', 'value' => '3552767669130143', 'group' => 'sambutan', 'label' => 'NUPTK'],
            ['key' => 'sambutan_teks', 'value' => "Assalamu’alaikum Warahmatullahi Wabarakatuh.\n\nSelamat datang di portal resmi PPDB SD Islam Plus Al-Wafa Batam. Kami mendedikasikan diri untuk membina ananda menjadi generasi penerus yang teguh memegang Al-Qur'an dan As-Sunnah, berakhlakul karimah, berkarakter mulia, serta siap menghadapi tantangan masa depan dengan kecakapan digital dan wawasan global.\n\nMari bersama kami merajut masa depan ananda tercinta di SD Islam Plus Al-Wafa.", 'group' => 'sambutan', 'label' => 'Isi Sambutan'],
            
            // Visi & Misi
            ['key' => 'visi', 'value' => "Terwujudnya Generasi Qur'ani yang Beriman, Berakhlak Mulia, Berkarakter, Cakap Digital, Berprestasi, dan Berwawasan Global.", 'group' => 'visi_misi', 'label' => 'Visi Sekolah'],
            ['key' => 'misi_1', 'value' => "Membentuk Generasi Qur'ani yang beriman, bertakwa, mencintai, dan mengamalkan Al-Qur'an.", 'group' => 'visi_misi', 'label' => 'Misi 1'],
            ['key' => 'misi_2', 'value' => "Membudayakan Akhlak Mulia dan Karakter Positif dalam kehidupan sehari-hari.", 'group' => 'visi_misi', 'label' => 'Misi 2'],
            ['key' => 'misi_3', 'value' => "Mengembangkan Potensi dan Prestasi peserta didik sesuai bakat, minat, dan kemampuannya.", 'group' => 'visi_misi', 'label' => 'Misi 3'],
            ['key' => 'misi_4', 'value' => "Menguatkan Literasi, Numerasi, dan Kecakapan Digital untuk menghadapi perkembangan zaman.", 'group' => 'visi_misi', 'label' => 'Misi 4'],
            ['key' => 'misi_5', 'value' => "Menumbuhkan Wawasan Global melalui pembelajaran yang kreatif, kolaboratif, adaptif, dan menghargai keberagaman.", 'group' => 'visi_misi', 'label' => 'Misi 5'],

            // Informasi & Pengumuman
            ['key' => 'pengumuman_headline', 'value' => 'Pendaftaran Peserta Didik Baru (PPDB) Tahun Pelajaran 2026/2027 Resmi Dibuka!', 'group' => 'pengumuman', 'label' => 'Headline Pengumuman'],
            ['key' => 'pengumuman_subtext', 'value' => 'Kuota terbatas untuk 3 rombongan belajar kelas 1 (Abu Bakar Ash-Shiddiq, Umar bin Khotthob, dan Utsman bin Affan). Segera daftarkan putra/putri Anda secara online.', 'group' => 'pengumuman', 'label' => 'Detail Pengumuman'],

            // Kontak & Layanan
            ['key' => 'kontak_telepon', 'value' => '0778 7495940', 'group' => 'kontak', 'label' => 'Telepon Kantor'],
            ['key' => 'kontak_whatsapp', 'value' => '081266812015', 'group' => 'kontak', 'label' => 'WhatsApp Panitia PPDB 1'],
            ['key' => 'kontak_whatsapp_2', 'value' => '082323222606', 'group' => 'kontak', 'label' => 'WhatsApp Panitia PPDB 2'],
            ['key' => 'kontak_email', 'value' => 'sdipalwafa@gmail.com', 'group' => 'kontak', 'label' => 'Email Resmi'],
            ['key' => 'kontak_alamat', 'value' => 'Bida Asri II Blok G2 No. 11 - 15 Kel. Belian, Kec. Batam Kota, Kota Batam - Kepulauan Riau (29464)', 'group' => 'kontak', 'label' => 'Alamat Lengkap'],
            ['key' => 'izin_diknas', 'value' => 'No. 21/421.3/DIKDAS/I/2015', 'group' => 'kontak', 'label' => 'Izin Diknas'],
            ['key' => 'npsn', 'value' => '69888848', 'group' => 'kontak', 'label' => 'NPSN Sekolah'],
            ['key' => 'yayasan', 'value' => 'Yayasan Daarul Aitam Batam', 'group' => 'kontak', 'label' => 'Nama Yayasan'],
        ];

        foreach ($settings as $s) {
            HomepageSetting::updateOrCreate(
                ['key' => $s['key']],
                [
                    'value' => $s['value'],
                    'group' => $s['group'],
                    'label' => $s['label'],
                ]
            );
        }
    }
}
