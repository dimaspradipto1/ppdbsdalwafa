<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use App\Models\Gelombang;
use App\Models\HomepageBanner;
use App\Models\HomepageSetting;
use App\Models\Jalur;
use App\Models\Pengumuman;
use App\Models\Sekolah;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    /**
     * Tampilkan Halaman Utama (Homepage) PPDB SD Islam Plus Al-Wafa Batam
     */
    public function index()
    {
        $banners = HomepageBanner::active()->get();
        $settings = HomepageSetting::getAllGrouped();
        $sekolah = Sekolah::first();
        $gelombangList = Gelombang::where('is_active', true)->orderBy('tanggal_mulai')->get();
        $jalurList = Jalur::where('is_active', true)->get();
        $biayaList = Biaya::where('is_active', true)->get();
        $tahunAktif = TahunAjaran::where('is_active', true)->first() ?? TahunAjaran::latest()->first();
        $pengumumanList = Pengumuman::where('is_published', true)->latest('tanggal_buka')->take(4)->get();

        // Data Nama Kelas Tematik Sahabat Nabi & Ulama (dari SK Pembagian Kelas SD Al-Wafa)
        $daftarKelas = [
            ['tingkat' => 'Kelas I', 'rombel' => 'I A', 'nama' => 'Abu Bakar Ash-Shiddiq', 'arab' => 'أبو بكر الصديق', 'wali' => 'Elisa, S.Pd.', 'pendamping' => 'Nur Islam Syaputry'],
            ['tingkat' => 'Kelas I', 'rombel' => 'I B', 'nama' => '\'Umar bin Khotthob', 'arab' => 'عمر بن الخطاب', 'wali' => 'Sulastri, S.Pd.', 'pendamping' => 'Nauval Afandi'],
            ['tingkat' => 'Kelas I', 'rombel' => 'I C', 'nama' => '\'Utsman bin Affan', 'arab' => 'عثمان بن عفان', 'wali' => 'Leni Meilani Lubis, S.Pd.', 'pendamping' => 'Fadli Alfahruf'],
            ['tingkat' => 'Kelas II', 'rombel' => 'II A', 'nama' => 'Hamzah bin Abdul Muttholib', 'arab' => 'حمزة بن عبد المطلب', 'wali' => 'Syamsidar, S.Pd.', 'pendamping' => 'Muhammad Dharmarag Saka'],
            ['tingkat' => 'Kelas II', 'rombel' => 'II B', 'nama' => 'Ali bin Abi Tholib', 'arab' => 'علي بن أبي طالب', 'wali' => 'Intan Syahwillyantri, S.Pd.', 'pendamping' => 'Zaenuddin, S.Kom'],
            ['tingkat' => 'Kelas III', 'rombel' => 'III A', 'nama' => 'Zubair bin \'Awwam', 'arab' => 'زبير بن عوام', 'wali' => 'Nur Ashifah, S.Pd.', 'pendamping' => 'Bunga Andini Pangestika, S.Pd'],
            ['tingkat' => 'Kelas III', 'rombel' => 'III B', 'nama' => 'Abdurrohman bin \'Auf', 'arab' => 'عبد الرحمن بن عوف', 'wali' => 'Mandasari Murdiyah, S.Pd', 'pendamping' => 'Aulia Zakirny Yasma, S.Pd'],
            ['tingkat' => 'Kelas III', 'rombel' => 'III C', 'nama' => 'Ibnu Hajar Al-\'Asqalani', 'arab' => 'ابن حجر العسقلاني', 'wali' => 'Putri Yulianti, S.Pd.I', 'pendamping' => 'Muhammad Arif'],
            ['tingkat' => 'Kelas IV', 'rombel' => 'IV A', 'nama' => 'Sa\'ad bin Abi Waqqosh', 'arab' => 'سعد بن أبي وقاص', 'wali' => 'Karmila Hasibuan, S.Pd.I', 'pendamping' => 'Veranica Sharlina'],
            ['tingkat' => 'Kelas IV', 'rombel' => 'IV B', 'nama' => 'Sa\'id bin Zaid', 'arab' => 'سعيد بن زيد', 'wali' => 'Elidesrina, S.Pd.', 'pendamping' => 'Ferdinan Ivan Ariska'],
            ['tingkat' => 'Kelas IV', 'rombel' => 'IV C', 'nama' => 'Harun Ar-Rasyid', 'arab' => 'هارون الرشيد', 'wali' => 'Asih Sri Rahayu, S.Pd', 'pendamping' => 'Riris Safitri, S.Pd.'],
            ['tingkat' => 'Kelas V', 'rombel' => 'V A', 'nama' => 'Abu \'Ubaidah bin Jarroh', 'arab' => 'أبو عبيدة بن الجراح', 'wali' => 'Nabila Qothrunnadaa, S.Pd.', 'pendamping' => 'Vicky Mahardika Ariwibowo, SH'],
            ['tingkat' => 'Kelas V', 'rombel' => 'V B', 'nama' => 'Kholid bin Walid', 'arab' => 'خالد بن الوليد', 'wali' => 'Riska Amelia Feminata, S.Pd.', 'pendamping' => 'Imam Khusairi Siregar'],
            ['tingkat' => 'Kelas V', 'rombel' => 'V C', 'nama' => 'Talhah bin \'Ubaidillah', 'arab' => 'طلحة بن عبيد الله', 'wali' => 'Sri Rose Junita, S.Pd.', 'pendamping' => 'Abdul Munim Al-harish'],
            ['tingkat' => 'Kelas VI', 'rombel' => 'VI A', 'nama' => 'Muhammad bin Idris Asy-Syafi\'i', 'arab' => 'محمد بن إدريس الشافعي', 'wali' => 'Halimatussaqdiya Hutasuhut, S.Pd.', 'pendamping' => 'Muhammad Bagus Adi Jaya'],
            ['tingkat' => 'Kelas VI', 'rombel' => 'VI B', 'nama' => 'Bilal bin Robah', 'arab' => 'بلال بن رباح', 'wali' => 'Ambarwati Dita Pratiwi, S.Pd.', 'pendamping' => 'Jaliha Ibrahim'],
            ['tingkat' => 'Kelas VI', 'rombel' => 'VI C', 'nama' => 'Salman Al-Farisi', 'arab' => 'سلمان الفارسي', 'wali' => 'Diah Ayu Maheswara, S.Pd.', 'pendamping' => 'Muhammad Syah Reza'],
        ];

        return view('layouts.homepage.template', compact(
            'banners',
            'settings',
            'sekolah',
            'gelombangList',
            'jalurList',
            'biayaList',
            'tahunAktif',
            'daftarKelas',
            'pengumumanList'
        ));
    }
}
