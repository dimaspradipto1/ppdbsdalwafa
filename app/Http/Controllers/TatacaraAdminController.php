<?php

namespace App\Http\Controllers;

use App\Models\HomepageSetting;
use Illuminate\Http\Request;

class TatacaraAdminController extends Controller
{
    /**
     * Tampilkan formulir khusus Kelola Tata Cara Pendaftaran PPDB
     */
    public function index()
    {
        $settings = HomepageSetting::getAllGrouped();
        return view('pages.tatacara_admin.index', compact('settings'));
    }

    /**
     * Simpan pembaruan konten tata cara pendaftaran
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'tatacara_judul'           => 'nullable|string|max:150',
            'tatacara_accordion_judul' => 'nullable|string|max:150',
            'tatacara_accordion_desc'  => 'nullable|string|max:255',
            'tatacara_1_judul'         => 'required|string|max:100',
            'tatacara_1_desc'          => 'required|string|max:300',
            'tatacara_2_judul'         => 'required|string|max:100',
            'tatacara_2_desc'          => 'required|string|max:300',
            'tatacara_3_judul'         => 'required|string|max:100',
            'tatacara_3_desc'          => 'required|string|max:300',
            'tatacara_4_judul'         => 'required|string|max:100',
            'tatacara_4_desc'          => 'required|string|max:300',

            // 7 Langkah Halaman Detail
            'tatacara_step1_judul'     => 'nullable|string|max:150',
            'tatacara_step1_desc'      => 'nullable|string|max:600',
            'tatacara_step2_judul'     => 'nullable|string|max:150',
            'tatacara_step2_desc'      => 'nullable|string|max:600',
            'tatacara_step3_judul'     => 'nullable|string|max:150',
            'tatacara_step3_desc'      => 'nullable|string|max:600',
            'tatacara_step4_judul'     => 'nullable|string|max:150',
            'tatacara_step4_desc'      => 'nullable|string|max:600',
            'tatacara_step5_judul'     => 'nullable|string|max:150',
            'tatacara_step5_desc'      => 'nullable|string|max:600',
            'tatacara_step6_judul'     => 'nullable|string|max:150',
            'tatacara_step6_desc'      => 'nullable|string|max:600',
            'tatacara_step7_judul'     => 'nullable|string|max:150',
            'tatacara_step7_desc'      => 'nullable|string|max:600',

            // Ketentuan Usia
            'tatacara_usia_prioritas'  => 'nullable|string|max:255',
            'tatacara_usia_standar'    => 'nullable|string|max:255',
            'tatacara_usia_khusus'     => 'nullable|string|max:255',
        ]);

        foreach ($validated as $key => $val) {
            HomepageSetting::set($key, $val ?? '', 'tatacara');
        }

        return redirect()->route('tatacara-setting.index')->with('success', 'Konten Tata Cara Pendaftaran berhasil diperbarui dan langsung aktif di homepage & halaman publik!');
    }
}
