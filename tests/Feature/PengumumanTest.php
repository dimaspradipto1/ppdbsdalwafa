<?php

namespace Tests\Feature;

use App\Models\CalonSiswa;
use App\Models\Gelombang;
use App\Models\Pengumuman;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PengumumanTest extends TestCase
{
    private function getSuperAdmin(): User
    {
        return User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('password'),
                'role'     => 'super_admin',
            ]
        );
    }

    private function getOrCreateCalonSiswa(): CalonSiswa
    {
        $siswa = CalonSiswa::first();
        if (!$siswa) {
            $siswa = CalonSiswa::create([
                'nama_lengkap'     => 'Test Siswa Pengumuman',
                'jenis_kelamin'    => 'Laki-laki',
                'tempat_lahir'     => 'Batam',
                'tanggal_lahir'    => '2019-02-10',
                'status'           => 'diterima',
            ]);
        }
        return $siswa;
    }

    public function test_admin_can_access_pengumuman_index(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)->get(route('pengumuman.index'));
        $response->assertStatus(200);
        $response->assertSee('Pengumuman Kelulusan');
    }

    public function test_datatables_ajax_returns_pengumuman_json(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)
            ->get(route('pengumuman.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data',
        ]);
    }

    public function test_can_create_and_store_pengumuman(): void
    {
        $admin = $this->getSuperAdmin();
        $tahun = TahunAjaran::first();
        $gelombang = Gelombang::first();

        $response = $this->actingAs($admin)->post(route('pengumuman.store'), [
            'id_tahun_ajaran' => $tahun?->id_tahun_ajaran,
            'id_gelombang'    => $gelombang?->id_gelombang,
            'judul'           => 'Pengumuman Resmi Kelulusan Gelombang 1',
            'nomor_surat'     => '421.2/PPDB/AL-WAFA/2026/001',
            'tanggal_buka'    => now()->toDateString(),
            'isi_pengumuman'  => 'Diberitahukan kepada seluruh orang tua calon peserta didik baru...',
            'is_published'    => '1',
        ]);

        $response->assertRedirect(route('pengumuman.index'));
        $this->assertDatabaseHas('pengumuman_ppdb', [
            'judul'       => 'Pengumuman Resmi Kelulusan Gelombang 1',
            'nomor_surat' => '421.2/PPDB/AL-WAFA/2026/001',
        ]);
    }

    public function test_can_show_pengumuman_with_student_list(): void
    {
        $admin = $this->getSuperAdmin();
        $pengumuman = Pengumuman::where('judul', 'Pengumuman Resmi Kelulusan Gelombang 1')->first();

        if (!$pengumuman) {
            $pengumuman = Pengumuman::create([
                'judul'        => 'Pengumuman Resmi Kelulusan Gelombang 1',
                'tanggal_buka' => now()->toDateString(),
                'is_published' => true,
            ]);
        }

        $response = $this->actingAs($admin)->get(route('pengumuman.show', $pengumuman->id_pengumuman));
        $response->assertStatus(200);
        $response->assertSee('Hasil Seleksi');
    }

    public function test_can_print_official_surat_kelulusan(): void
    {
        $admin = $this->getSuperAdmin();
        $siswa = $this->getOrCreateCalonSiswa();

        $response = $this->actingAs($admin)->get(route('pengumuman.surat-kelulusan', $siswa->id_calon_siswa));
        $response->assertStatus(200);
        $response->assertSee('SURAT KEPUTUSAN KELULUSAN SELEKSI PPDB');
        $response->assertSee($siswa->nama_lengkap);
    }

    public function test_can_delete_pengumuman(): void
    {
        $admin = $this->getSuperAdmin();
        $pengumuman = Pengumuman::where('judul', 'Pengumuman Resmi Kelulusan Gelombang 1')->first();

        if ($pengumuman) {
            $response = $this->actingAs($admin)->delete(route('pengumuman.destroy', $pengumuman->id_pengumuman));
            $response->assertRedirect(route('pengumuman.index'));

            $this->assertDatabaseMissing('pengumuman_ppdb', [
                'id_pengumuman' => $pengumuman->id_pengumuman,
            ]);
        }
    }
}
