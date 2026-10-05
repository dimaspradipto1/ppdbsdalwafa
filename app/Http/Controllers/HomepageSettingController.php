<?php

namespace App\Http\Controllers;

use App\Models\HomepageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomepageSettingController extends Controller
{
    /**
     * Tampilkan halaman formulir pengaturan konten homepage
     */
    public function index()
    {
        $settings = HomepageSetting::all()->pluck('value', 'key')->toArray();
        return view('pages.homepage_setting.index', compact('settings'));
    }

    /**
     * Simpan pembaruan pengaturan konten homepage
     */
    public function update(Request $request)
    {
        $input = $request->except(['_token', 'sambutan_foto', 'brosur_file', 'hapus_brosur_file', 'hapus_sambutan_foto']);

        foreach ($input as $key => $val) {
            $group = 'general';
            if (str_starts_with($key, 'sambutan_')) {
                $group = 'sambutan';
            } elseif (str_starts_with($key, 'misi_') || $key === 'visi') {
                $group = 'visi_misi';
            } elseif (str_starts_with($key, 'kontak_') || in_array($key, ['npsn', 'izin_diknas', 'yayasan'])) {
                $group = 'kontak';
            } elseif (str_starts_with($key, 'pengumuman_')) {
                $group = 'pengumuman';
            } elseif (str_starts_with($key, 'tatacara_')) {
                $group = 'tatacara';
            } elseif (str_starts_with($key, 'brosur_')) {
                $group = 'brosur';
            }

            HomepageSetting::set($key, $val, $group);
        }

        // Hapus file brosur jika dicentang
        if ($request->boolean('hapus_brosur_file')) {
            $oldBrosur = HomepageSetting::get('brosur_file');
            if ($oldBrosur && File::exists(public_path($oldBrosur))) {
                File::delete(public_path($oldBrosur));
            }
            HomepageSetting::set('brosur_file', '', 'brosur', 'File Brosur PPDB');
        }

        // Upload file brosur PPDB jika ada
        if ($request->hasFile('brosur_file')) {
            $file = $request->file('brosur_file');
            $filename = 'brosur_ppdb_' . time() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('assets/uploads/brosur');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true, true);
            }
            $file->move($destination, $filename);
            HomepageSetting::set('brosur_file', 'assets/uploads/brosur/' . $filename, 'brosur', 'File Brosur PPDB');
        }

        // Upload foto kepala sekolah jika ada
        if ($request->hasFile('sambutan_foto')) {
            $file = $request->file('sambutan_foto');
            $filename = 'kepsek_' . time() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('assets/uploads/kepsek');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true, true);
            }
            $file->move($destination, $filename);
            HomepageSetting::set('sambutan_foto', 'assets/uploads/kepsek/' . $filename, 'sambutan', 'Foto Kepala Sekolah');
        }

        return redirect()->route('homepage-setting.index')->with('success', 'Pengaturan konten homepage & brosur berhasil disimpan!');
    }
}
