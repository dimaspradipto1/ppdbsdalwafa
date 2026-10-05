<?php

namespace App\Http\Controllers;

use App\Models\HomepageSetting;
use Illuminate\Http\Request;

class WaAdminController extends Controller
{
    /**
     * Tampilkan halaman khusus Pengaturan WhatsApp Admin
     */
    public function index()
    {
        $settings = HomepageSetting::getAllGrouped();
        return view('pages.wa_admin.index', compact('settings'));
    }

    /**
     * Simpan pembaruan Pengaturan WhatsApp Admin
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'kontak_whatsapp'    => 'required|string|max:25',
            'kontak_whatsapp_2'  => 'nullable|string|max:25',
            'wa_admin_nama'      => 'nullable|string|max:100',
            'cta_wa_text'        => 'required|string|max:500',
            'cta_judul'          => 'required|string|max:150',
            'cta_subjudul'       => 'nullable|string|max:255',
            'kontak_jam'         => 'nullable|string|max:100',
        ]);

        // Simpan key pengaturan ke homepage_settings
        foreach ($validated as $key => $val) {
            HomepageSetting::set($key, $val, 'kontak');
        }

        // Simpan toggle switch
        HomepageSetting::set('floating_wa_active', $request->has('floating_wa_active') ? '1' : '0', 'kontak');
        HomepageSetting::set('cta_wa_active', $request->has('cta_wa_active') ? '1' : '0', 'kontak');

        return redirect()->route('wa-admin.index')->with('success', 'Pengaturan WhatsApp Admin berhasil disimpan dan tersinkronisasi ke tampilan homepage!');
    }
}
