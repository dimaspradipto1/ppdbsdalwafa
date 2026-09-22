<?php

namespace Tests\Feature;

use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SekolahTest extends TestCase
{
    private function getSuperAdmin(): User
    {
        return User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
            ]
        );
    }

    public function test_super_admin_can_access_sekolah_profile_index(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)->get(route('sekolah.index'));
        $response->assertStatus(200);
        $response->assertSee('Profil & Data Sekolah', false);
        $response->assertSee('Simpan Perubahan Sekolah');
    }

    public function test_unauthorized_role_cannot_access_sekolah(): void
    {
        $pendaftar = User::firstOrCreate(
            ['email' => 'pendaftar@gmail.com'],
            [
                'name' => 'Pendaftar',
                'password' => Hash::make('password'),
                'role' => 'pendaftar',
            ]
        );

        $response = $this->actingAs($pendaftar)->get(route('sekolah.index'));
        $response->assertStatus(403);
    }

    public function test_super_admin_can_update_sekolah(): void
    {
        $admin = $this->getSuperAdmin();

        $sekolah = Sekolah::firstOrCreate(
            ['npsn' => '69888848'],
            [
                'nama_sekolah'   => 'SD Islam Plus Al-Wafa',
                'jenjang'        => 'SD',
                'status_sekolah' => 'Swasta',
            ]
        );

        $updateData = [
            'npsn'           => '69888848',
            'nama_sekolah'   => 'SD Islam Plus Al-Wafa Batam Updated',
            'jenjang'        => 'SD',
            'status_sekolah' => 'Swasta',
            'telepon'        => '082323222606',
            'nama_yayasan'   => 'Yayasan Daarul Aitam Batam',
        ];

        $response = $this->actingAs($admin)->put(route('sekolah.update', $sekolah->id_sekolah), $updateData);
        $response->assertRedirect(route('sekolah.index'));

        $sekolah->refresh();
        $this->assertEquals('SD Islam Plus Al-Wafa Batam Updated', $sekolah->nama_sekolah);
        $this->assertEquals('082323222606', $sekolah->telepon);
    }

    public function test_super_admin_can_view_sekolah_json(): void
    {
        $admin = $this->getSuperAdmin();
        $sekolah = Sekolah::first();

        $response = $this->actingAs($admin)->get(route('sekolah.show', $sekolah->id_sekolah));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id_sekolah',
            'nama_sekolah',
            'jenjang',
            'status_sekolah',
        ]);
    }

    public function test_super_admin_can_update_logo_via_ajax(): void
    {
        $admin = $this->getSuperAdmin();
        $sekolah = Sekolah::first() ?? Sekolah::create([
            'nama_sekolah'   => 'SD Islam Plus Al-Wafa',
            'jenjang'        => 'SD',
            'status_sekolah' => 'Swasta',
        ]);

        $file = UploadedFile::fake()->image('new_logo.png', 200, 200);

        $response = $this->actingAs($admin)
            ->post(route('sekolah.update-logo'), [
                'logo' => $file,
            ], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $sekolah->refresh();
        $this->assertNotNull($sekolah->logo_path);
        $this->assertFileExists(public_path($sekolah->logo_path));

        // Clean up test generated file
        if (file_exists(public_path($sekolah->logo_path))) {
            @unlink(public_path($sekolah->logo_path));
        }
    }
}
