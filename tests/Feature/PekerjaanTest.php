<?php

namespace Tests\Feature;

use App\Models\Pekerjaan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PekerjaanTest extends TestCase
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

    public function test_super_admin_can_access_pekerjaan_index(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)->get(route('pekerjaan.index'));
        $response->assertStatus(200);
        $response->assertSee('Master Data Pekerjaan');
    }

    public function test_datatables_ajax_returns_pekerjaan_json(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)
            ->get(route('pekerjaan.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data'
        ]);
    }

    public function test_unauthorized_role_cannot_access_pekerjaan(): void
    {
        $pendaftar = User::firstOrCreate(
            ['email' => 'pendaftar@gmail.com'],
            [
                'name'     => 'Pendaftar',
                'password' => Hash::make('password'),
                'role'     => 'pendaftar',
            ]
        );

        $response = $this->actingAs($pendaftar)->get(route('pekerjaan.index'));
        $response->assertStatus(403);
    }

    public function test_super_admin_can_create_pekerjaan(): void
    {
        $admin = $this->getSuperAdmin();

        Pekerjaan::where('nama_pekerjaan', 'Pekerjaan Uji Coba')->delete();

        $data = [
            'nama_pekerjaan' => 'Pekerjaan Uji Coba',
            'keterangan'     => 'Keterangan uji coba',
            'is_active'      => 1,
        ];

        $response = $this->actingAs($admin)->post(route('pekerjaan.store'), $data);
        $response->assertRedirect(route('pekerjaan.index'));

        $this->assertDatabaseHas('pekerjaan', [
            'nama_pekerjaan' => 'Pekerjaan Uji Coba',
            'is_active'      => true,
        ]);
    }

    public function test_super_admin_can_update_pekerjaan(): void
    {
        $admin = $this->getSuperAdmin();

        Pekerjaan::whereIn('nama_pekerjaan', ['Pekerjaan To Edit', 'Pekerjaan To Edit Updated'])->delete();

        $pekerjaan = Pekerjaan::create([
            'nama_pekerjaan' => 'Pekerjaan To Edit',
            'keterangan'     => 'Keterangan awal',
            'is_active'      => true,
        ]);

        $updateData = [
            'nama_pekerjaan' => 'Pekerjaan To Edit Updated',
            'keterangan'     => 'Keterangan diperbarui',
            'is_active'      => 1,
        ];

        $response = $this->actingAs($admin)->put(route('pekerjaan.update', $pekerjaan->id_pekerjaan), $updateData);
        $response->assertRedirect(route('pekerjaan.index'));

        $pekerjaan->refresh();
        $this->assertEquals('Pekerjaan To Edit Updated', $pekerjaan->nama_pekerjaan);
        $this->assertEquals('Keterangan diperbarui', $pekerjaan->keterangan);
    }

    public function test_super_admin_can_delete_pekerjaan_via_ajax(): void
    {
        $admin = $this->getSuperAdmin();

        Pekerjaan::where('nama_pekerjaan', 'Pekerjaan To Delete')->delete();

        $pekerjaan = Pekerjaan::create([
            'nama_pekerjaan' => 'Pekerjaan To Delete',
            'keterangan'     => 'Akan dihapus',
            'is_active'      => true,
        ]);

        $response = $this->actingAs($admin)
            ->delete(route('pekerjaan.destroy', $pekerjaan->id_pekerjaan), [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseMissing('pekerjaan', ['id_pekerjaan' => $pekerjaan->id_pekerjaan]);
    }
}
