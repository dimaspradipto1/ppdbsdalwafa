<?php

namespace App\Http\Controllers;

use App\Models\HomepageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BrosurAdminController extends Controller
{
    /**
     * Tampilkan formulir khusus kelola brosur PPDB (Upload File & Link Google Drive)
     */
    public function index()
    {
        $settings = HomepageSetting::getAllGrouped();

        // Default berkas brosur jika belum ada
        $defaultBrosur = 'assets/uploads/brosur/brosur-ppdb-alwafa.pdf';
        $activeBrosurFile = !empty($settings['brosur_file']) ? $settings['brosur_file'] : (file_exists(public_path($defaultBrosur)) ? $defaultBrosur : null);

        return view('pages.brosur_admin.index', compact('settings', 'activeBrosurFile'));
    }

    /**
     * Simpan pembaruan berkas brosur atau link Google Drive
     */
    public function update(Request $request)
    {
        $request->validate([
            'brosur_judul'       => 'nullable|string|max:150',
            'brosur_deskripsi'   => 'nullable|string|max:600',
            'brosur_link'        => 'nullable|url|max:300',
            'brosur_file'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:15360',
            'biaya_catatan'      => 'nullable|string|max:600',
        ]);

        // Simpan teks pengaturan
        HomepageSetting::set('brosur_judul', $request->input('brosur_judul', 'Brosur Resmi PPDB Al-Wafa'), 'brosur', 'Judul Kartu Brosur');
        HomepageSetting::set('brosur_deskripsi', $request->input('brosur_deskripsi', 'Unduh dokumen brosur cetak berisi profil sekolah, keunggulan program tahfidz Qur’an, fasilitas belajar smart class, dan rincian lengkap biaya pendidikan.'), 'brosur', 'Deskripsi Brosur');
        HomepageSetting::set('brosur_link', $request->input('brosur_link'), 'brosur', 'Link Google Drive Brosur (Opsional)');
        
        if ($request->filled('biaya_catatan')) {
            HomepageSetting::set('biaya_catatan', $request->input('biaya_catatan'), 'brosur', 'Catatan Angsuran Biaya');
        }

        // Hapus file brosur jika dicentang
        if ($request->boolean('hapus_brosur_file')) {
            $oldBrosur = HomepageSetting::get('brosur_file');
            if ($oldBrosur && File::exists(public_path($oldBrosur))) {
                File::delete(public_path($oldBrosur));
            }
            HomepageSetting::set('brosur_file', '', 'brosur', 'File Brosur PPDB');
        }

        // Upload berkas brosur baru jika diunggah
        if ($request->hasFile('brosur_file')) {
            $file = $request->file('brosur_file');
            $filename = 'brosur_alwafa_' . time() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('assets/uploads/brosur');

            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true, true);
            }

            $file->move($destination, $filename);
            HomepageSetting::set('brosur_file', 'assets/uploads/brosur/' . $filename, 'brosur', 'File Brosur PPDB');
        }

        return redirect()->route('brosur-setting.index')->with('success', 'Brosur PPDB berhasil diperbarui dan langsung aktif di halaman website!');
    }
}
