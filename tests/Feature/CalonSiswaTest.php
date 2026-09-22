<?php

namespace Tests\Feature;

use App\Models\CalonSiswa;
use App\Models\Gelombang;
use App\Models\Jalur;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CalonSiswaTest extends TestCase
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

    public function test_super_admin_can_access_calon_siswa_index(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)->get(route('calon-siswa.index'));
        $response->assertStatus(200);
        $response->assertSee('Data Pendaftaran Calon Siswa');
    }

    public function test_datatables_ajax_returns_calon_siswa_json(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)
            ->get(route('calon-siswa.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data',
        ]);
    }

    public function test_store_calon_siswa_auto_generates_no_pendaftaran(): void
    {
        $admin = $this->getSuperAdmin();
        $tahun = TahunAjaran::first();
        $gelombang = Gelombang::first();
        $jalur = Jalur::first();

        $response = $this->actingAs($admin)->post(route('calon-siswa.store'), [
            'id_tahun_ajaran'        => $tahun?->id_tahun_ajaran,
            'id_gelombang'           => $gelombang?->id_gelombang,
            'id_jalur'               => $jalur?->id_jalur,
            'nama_lengkap'           => 'Ahmad Fathi Mubarak',
            'jenis_kelamin'          => 'Laki-laki',
            'tempat_lahir'           => 'Batam',
            'tanggal_lahir'          => '2019-05-12',
            'asal_sekolah'           => 'TK Islam Al-Wafa Batam',
            'nama_ayah'              => 'Mubarak Ali',
            'nama_ibu'               => 'Siti Aisyah',
            'status'                 => 'menunggu_verifikasi',
        ]);

        $response->assertRedirect(route('calon-siswa.index'));
        $this->assertDatabaseHas('calon_siswa', [
            'nama_lengkap' => 'Ahmad Fathi Mubarak',
            'tempat_lahir' => 'Batam',
        ]);

        $siswa = CalonSiswa::where('nama_lengkap', 'Ahmad Fathi Mubarak')->first();
        $this->assertNotNull($siswa->no_pendaftaran);
        $this->assertStringStartsWith('REG-', $siswa->no_pendaftaran);
    }

    public function test_can_update_status_calon_siswa(): void
    {
        $admin = $this->getSuperAdmin();
        $siswa = CalonSiswa::where('nama_lengkap', 'Ahmad Fathi Mubarak')->first();

        if (!$siswa) {
            $siswa = CalonSiswa::create([
                'nama_lengkap'  => 'Ahmad Fathi Mubarak',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir'  => 'Batam',
                'tanggal_lahir' => '2019-05-12',
                'status'        => 'menunggu_verifikasi',
            ]);
        }

        $response = $this->actingAs($admin)
            ->patchJson(route('calon-siswa.update-status', $siswa->id_calon_siswa), [
                'status'             => 'diverifikasi',
                'catatan_verifikasi' => 'Berkas pendaftaran telah lengkap dan sah.',
            ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('calon_siswa', [
            'id_calon_siswa'     => $siswa->id_calon_siswa,
            'status'             => 'diverifikasi',
            'catatan_verifikasi' => 'Berkas pendaftaran telah lengkap dan sah.',
        ]);
    }

    public function test_can_show_calon_siswa_detail(): void
    {
        $admin = $this->getSuperAdmin();
        $siswa = CalonSiswa::where('nama_lengkap', 'Ahmad Fathi Mubarak')->first();

        $response = $this->actingAs($admin)->get(route('calon-siswa.show', $siswa->id_calon_siswa));
        $response->assertStatus(200);
        $response->assertSee('Ahmad Fathi Mubarak');
    }

    public function test_can_delete_calon_siswa(): void
    {
        $admin = $this->getSuperAdmin();
        $siswa = CalonSiswa::where('nama_lengkap', 'Ahmad Fathi Mubarak')->first();

        $response = $this->actingAs($admin)->delete(route('calon-siswa.destroy', $siswa->id_calon_siswa));
        $response->assertRedirect(route('calon-siswa.index'));
        $this->assertDatabaseMissing('calon_siswa', [
            'id_calon_siswa' => $siswa->id_calon_siswa,
        ]);
    }
}
