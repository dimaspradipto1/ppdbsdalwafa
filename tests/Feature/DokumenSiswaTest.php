<?php

namespace Tests\Feature;

use App\Models\CalonSiswa;
use App\Models\DokumenSiswa;
use App\Models\JenisDokumen;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DokumenSiswaTest extends TestCase
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

    public function test_super_admin_can_access_dokumen_index(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)->get(route('dokumen.index'));
        $response->assertStatus(200);
        $response->assertSee('Verifikasi Dokumen');
    }

    public function test_datatables_ajax_returns_dokumen_json(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)
            ->get(route('dokumen.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data',
        ]);
    }

    public function test_can_upload_and_verify_dokumen(): void
    {
        Storage::fake('public');
        $admin = $this->getSuperAdmin();

        $siswa = CalonSiswa::first() ?? CalonSiswa::create([
            'nama_lengkap'  => 'Siswa Dokumen Test',
            'jenis_kelamin' => 'Laki-laki',
            'tempat_lahir'  => 'Batam',
            'tanggal_lahir' => '2019-01-01',
        ]);

        $jenis = JenisDokumen::first();

        // 1. Upload
        $file = UploadedFile::fake()->create('akta_kelahiran.pdf', 200, 'application/pdf');

        $response = $this->actingAs($admin)->post(route('dokumen.store'), [
            'id_calon_siswa'    => $siswa->id_calon_siswa,
            'id_jenis_dokumen'  => $jenis->id_jenis_dokumen,
            'berkas'            => $file,
            'status_verifikasi' => 'menunggu',
        ]);

        $response->assertRedirect(route('dokumen.index'));
        $this->assertDatabaseHas('dokumen_siswa', [
            'id_calon_siswa'    => $siswa->id_calon_siswa,
            'id_jenis_dokumen'  => $jenis->id_jenis_dokumen,
            'status_verifikasi' => 'menunggu',
        ]);

        $dokumen = DokumenSiswa::where('id_calon_siswa', $siswa->id_calon_siswa)->latest('id_dokumen')->first();

        // 2. Update / Verifikasi
        $updateResponse = $this->actingAs($admin)->put(route('dokumen.update', $dokumen->id_dokumen), [
            'id_calon_siswa'     => $siswa->id_calon_siswa,
            'id_jenis_dokumen'   => $jenis->id_jenis_dokumen,
            'status_verifikasi'  => 'valid',
            'catatan_verifikasi' => 'Berkas asli dan jelas.',
        ]);

        $updateResponse->assertRedirect(route('dokumen.index'));
        $this->assertDatabaseHas('dokumen_siswa', [
            'id_dokumen'        => $dokumen->id_dokumen,
            'status_verifikasi' => 'valid',
        ]);

        // 3. Delete
        $deleteResponse = $this->actingAs($admin)->delete(route('dokumen.destroy', $dokumen->id_dokumen));
        $deleteResponse->assertRedirect(route('dokumen.index'));
        $this->assertDatabaseMissing('dokumen_siswa', [
            'id_dokumen' => $dokumen->id_dokumen,
        ]);
    }
}
