<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSekolahRequest;
use App\Http\Requests\UpdateSekolahRequest;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    /**
     * Tampilkan profil dan form pengaturan data sekolah utama langsung (single-school management)
     */
    public function index()
    {
        // Ambil sekolah utama atau inisialisasi jika belum ada
        $sekolah = Sekolah::first() ?? Sekolah::create([
            'nama_sekolah'   => 'SD Islam Plus Al-Wafa',
            'jenjang'        => 'SD',
            'status_sekolah' => 'Swasta',
            'nama_yayasan'   => 'Yayasan Daarul Aitam Batam (YDAB)',
            'alamat'         => 'Perumahan Bida Asri 2 Blok G2 No. 10-15',
            'desa_kelurahan' => 'Belian',
            'kecamatan'      => 'Batam Kota',
            'kabupaten_kota' => 'Kota Batam',
            'provinsi'       => 'Kepulauan Riau',
            'kode_pos'       => '29464',
            'telepon'        => '082323222606',
            'email'          => 'sdipalwafa@gmail.com',
            'website'        => 'https://alwafaislamicschool.com',
            'logo_path'      => 'assets/img/cropped-lodo-sdip-alwafa.webp',
        ]);

        $jenjangList = Sekolah::JENJANG;
        $statusList = Sekolah::STATUS;

        return view('pages.sekolah.index', compact('sekolah', 'jenjangList', 'statusList'));
    }

    /**
     * Form tambah sekolah (diarahkan ke halaman pengaturan profil sekolah utama)
     */
    public function create()
    {
        return redirect()->route('sekolah.index');
    }

    /**
     * Simpan data sekolah (jika sudah ada, lakukan update pada sekolah utama)
     */
    public function store(StoreSekolahRequest $request)
    {
        $sekolah = Sekolah::first();
        if ($sekolah) {
            return $this->update(UpdateSekolahRequest::createFrom($request), $sekolah);
        }

        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'logo_sekolah_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('assets/uploads/sekolah');

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);
            $data['logo_path'] = 'assets/uploads/sekolah/' . $filename;
        }

        unset($data['logo']);

        Sekolah::create($data);

        return redirect()->route('sekolah.index')->with('success', 'Data sekolah berhasil disimpan!');
    }

    /**
     * Tampilkan detail sekolah
     */
    public function show(Sekolah $sekolah = null)
    {
        $sekolah = ($sekolah && $sekolah->exists) ? $sekolah : (Sekolah::first() ?? new Sekolah());
        return response()->json($sekolah);
    }

    /**
     * Form edit sekolah (diarahkan langsung ke halaman profil sekolah utama)
     */
    public function edit(Sekolah $sekolah = null)
    {
        return redirect()->route('sekolah.index');
    }

    /**
     * Perbarui data sekolah utama dan simpan perubahan
     */
    public function update(UpdateSekolahRequest $request, Sekolah $sekolah = null)
    {
        $sekolah = ($sekolah && $sekolah->exists) ? $sekolah : (Sekolah::first() ?? new Sekolah());

        $data = $request->validated();

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika berada di direktori upload custom
            if ($sekolah->logo_path && str_starts_with($sekolah->logo_path, 'assets/uploads/')) {
                $oldFile = public_path($sekolah->logo_path);
                if (file_exists($oldFile)) {
                    @unlink($oldFile);
                }
            }

            $file = $request->file('logo');
            $filename = 'logo_sekolah_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('assets/uploads/sekolah');

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);
            $data['logo_path'] = 'assets/uploads/sekolah/' . $filename;
        }

        unset($data['logo']);

        $sekolah->fill($data);
        $sekolah->save();

        return redirect()->route('sekolah.index')->with('success', 'Data profil sekolah berhasil diperbarui!');
    }

    /**
     * Upload dan ganti logo sekolah langsung (mendukung AJAX & form upload)
     */
    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ], [
            'logo.required' => 'Silakan pilih file logo terlebih dahulu.',
            'logo.image'    => 'File harus berupa gambar.',
            'logo.mimes'    => 'Format logo harus berupa JPG, JPEG, PNG, WEBP, atau SVG.',
            'logo.max'      => 'Ukuran logo maksimal 2MB.',
        ]);

        $sekolah = Sekolah::first() ?? Sekolah::create([
            'nama_sekolah'   => 'SD Islam Plus Al-Wafa',
            'jenjang'        => 'SD',
            'status_sekolah' => 'Swasta',
        ]);

        $file = $request->file('logo');
        $filename = 'logo_sekolah_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $destination = public_path('assets/uploads/sekolah');

        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        // Hapus logo lama jika berada di direktori upload custom
        if ($sekolah->logo_path && str_starts_with($sekolah->logo_path, 'assets/uploads/')) {
            $oldFile = public_path($sekolah->logo_path);
            if (file_exists($oldFile)) {
                @unlink($oldFile);
            }
        }

        $file->move($destination, $filename);
        $sekolah->logo_path = 'assets/uploads/sekolah/' . $filename;
        $sekolah->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'  => true,
                'message'  => 'Logo sekolah berhasil diganti!',
                'logo_url' => asset($sekolah->logo_path),
            ]);
        }

        return redirect()->route('sekolah.index')->with('success', 'Logo sekolah berhasil diganti!');
    }

    /**
     * Hapus data sekolah (opsional untuk testing / kebutuhan reset)
     */
    public function destroy(Request $request, Sekolah $sekolah)
    {
        $nama = $sekolah->nama_sekolah;

        if ($sekolah->logo_path && str_starts_with($sekolah->logo_path, 'assets/uploads/')) {
            $oldFile = public_path($sekolah->logo_path);
            if (file_exists($oldFile)) {
                @unlink($oldFile);
            }
        }

        $sekolah->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Sekolah ' . $nama . ' berhasil dihapus!',
            ]);
        }

        return redirect()->route('sekolah.index')->with('success', 'Sekolah ' . $nama . ' berhasil dihapus!');
    }
}
