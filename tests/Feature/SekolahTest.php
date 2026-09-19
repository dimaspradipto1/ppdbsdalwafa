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

    public function test_super_admin_can_access_sekolah_index(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)->get(route('sekolah.index'));
        $response->assertStatus(200);
        $response->assertSee('Data Sekolah');
    }

    public function test_datatables_ajax_returns_sekolah_json(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)
            ->get(route('sekolah.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data'
        ]);
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

    public function test_super_admin_can_create_sekolah(): void
    {
        $admin = $this->getSuperAdmin();

        Sekolah::where('npsn', '12345678')->delete();

        $data = [
            'npsn'           => '12345678',
            'nama_sekolah'   => 'TK Islam Plus Al-Wafa',
            'jenjang'        => 'TK',
            'status_sekolah' => 'Swasta',
            'nama_yayasan'   => 'Yayasan Daarul Aitam Batam',
            'alamat'         => 'Perumahan Bida Asri 2 Blok I No. 5-6',
            'desa_kelurahan' => 'Belian',
            'kecamatan'      => 'Batam Kota',
            'kabupaten_kota' => 'Kota Batam',
            'provinsi'       => 'Kepulauan Riau',
            'telepon'        => '07787495611',
            'email'          => 'tkalwafa@gmail.com',
        ];

        $response = $this->actingAs($admin)->post(route('sekolah.store'), $data);
        $response->assertRedirect(route('sekolah.index'));

        $this->assertDatabaseHas('sekolah', [
            'npsn'         => '12345678',
            'nama_sekolah' => 'TK Islam Plus Al-Wafa',
        ]);
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
        ];

        $response = $this->actingAs($admin)->put(route('sekolah.update', $sekolah->id_sekolah), $updateData);
        $response->assertRedirect(route('sekolah.index'));

        $sekolah->refresh();
        $this->assertEquals('SD Islam Plus Al-Wafa Batam Updated', $sekolah->nama_sekolah);
    }

    public function test_super_admin_can_delete_sekolah(): void
    {
        $admin = $this->getSuperAdmin();

        $sekolah = Sekolah::create([
            'npsn'           => '99999999',
            'nama_sekolah'   => 'Sekolah Test Delete',
            'jenjang'        => 'SD',
            'status_sekolah' => 'Swasta',
        ]);

        $response = $this->actingAs($admin)
            ->delete(route('sekolah.destroy', $sekolah->id_sekolah), [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('sekolah', ['id_sekolah' => $sekolah->id_sekolah]);
    }
}
