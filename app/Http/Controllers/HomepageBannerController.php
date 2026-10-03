<?php

namespace App\Http\Controllers;

use App\Models\HomepageBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomepageBannerController extends Controller
{
    /**
     * Tampilkan daftar banner homepage
     */
    public function index()
    {
        $banners = HomepageBanner::orderBy('urutan')->get();
        return view('pages.homepage_banner.index', compact('banners'));
    }

    /**
     * Form tambah banner baru
     */
    public function create()
    {
        return view('pages.homepage_banner.create');
    }

    /**
     * Simpan banner baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'         => 'required|string|max:255',
            'subjudul'      => 'nullable|string',
            'badge_text'    => 'nullable|string|max:100',
            'gambar'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'tombol_text_1' => 'nullable|string|max:50',
            'tombol_link_1' => 'nullable|string|max:255',
            'tombol_text_2' => 'nullable|string|max:50',
            'tombol_link_2' => 'nullable|string|max:255',
            'urutan'        => 'nullable|integer',
            'is_active'     => 'boolean',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = 'banner_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('assets/uploads/banners');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true, true);
            }
            $file->move($destination, $filename);
            $validated['gambar'] = 'assets/uploads/banners/' . $filename;
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['urutan'] = $request->input('urutan', 1);

        HomepageBanner::create($validated);

        return redirect()->route('homepage-banner.index')->with('success', 'Banner homepage berhasil ditambahkan!');
    }

    /**
     * Form edit banner
     */
    public function edit(HomepageBanner $homepageBanner)
    {
        return view('pages.homepage_banner.edit', ['banner' => $homepageBanner]);
    }

    /**
     * Update banner
     */
    public function update(Request $request, HomepageBanner $homepageBanner)
    {
        $validated = $request->validate([
            'judul'         => 'required|string|max:255',
            'subjudul'      => 'nullable|string',
            'badge_text'    => 'nullable|string|max:100',
            'gambar'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'tombol_text_1' => 'nullable|string|max:50',
            'tombol_link_1' => 'nullable|string|max:255',
            'tombol_text_2' => 'nullable|string|max:50',
            'tombol_link_2' => 'nullable|string|max:255',
            'urutan'        => 'nullable|integer',
            'is_active'     => 'boolean',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada dan ada di folder uploads
            if ($homepageBanner->gambar && file_exists(public_path($homepageBanner->gambar)) && str_contains($homepageBanner->gambar, 'uploads/banners')) {
                @unlink(public_path($homepageBanner->gambar));
            }

            $file = $request->file('gambar');
            $filename = 'banner_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('assets/uploads/banners');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true, true);
            }
            $file->move($destination, $filename);
            $validated['gambar'] = 'assets/uploads/banners/' . $filename;
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['urutan'] = $request->input('urutan', 1);

        $homepageBanner->update($validated);

        return redirect()->route('homepage-banner.index')->with('success', 'Banner homepage berhasil diperbarui!');
    }

    /**
     * Hapus banner
     */
    public function destroy(HomepageBanner $homepageBanner)
    {
        if ($homepageBanner->gambar && file_exists(public_path($homepageBanner->gambar)) && str_contains($homepageBanner->gambar, 'uploads/banners')) {
            @unlink(public_path($homepageBanner->gambar));
        }

        $homepageBanner->delete();

        return redirect()->route('homepage-banner.index')->with('success', 'Banner homepage berhasil dihapus!');
    }
}
