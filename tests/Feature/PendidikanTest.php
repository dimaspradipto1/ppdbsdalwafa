<?php

namespace Tests\Feature;

use App\Models\Pendidikan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PendidikanTest extends TestCase
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

    public function test_super_admin_can_access_pendidikan_index(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)->get(route('pendidikan.index'));
        $response->assertStatus(200);
        $response->assertSee('Master Data Jenjang Pendidikan');
    }

    public function test_datatables_ajax_returns_pendidikan_json(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)
            ->get(route('pendidikan.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data'
        ]);
    }

    public function test_unauthorized_role_cannot_access_pendidikan(): void
    {
        $pendaftar = User::firstOrCreate(
            ['email' => 'pendaftar@gmail.com'],
            [
                'name'     => 'Pendaftar',
                'password' => Hash::make('password'),
                'role'     => 'pendaftar',
            ]
        );

        $response = $this->actingAs($pendaftar)->get(route('pendidikan.index'));
        $response->assertStatus(403);
    }

    public function test_super_admin_can_create_pendidikan(): void
    {
        $admin = $this->getSuperAdmin();

        Pendidikan::where('nama_pendidikan', 'Pendidikan Uji Coba')->delete();

        $data = [
            'nama_pendidikan' => 'Pendidikan Uji Coba',
            'keterangan'      => 'Keterangan uji coba',
            'is_active'       => 1,
        ];

        $response = $this->actingAs($admin)->post(route('pendidikan.store'), $data);
        $response->assertRedirect(route('pendidikan.index'));

        $this->assertDatabaseHas('pendidikan', [
            'nama_pendidikan' => 'Pendidikan Uji Coba',
            'is_active'       => true,
        ]);
    }

    public function test_super_admin_can_update_pendidikan(): void
    {
        $admin = $this->getSuperAdmin();

        Pendidikan::whereIn('nama_pendidikan', ['Pendidikan To Edit', 'Pendidikan To Edit Updated'])->delete();

        $pendidikan = Pendidikan::create([
            'nama_pendidikan' => 'Pendidikan To Edit',
            'keterangan'      => 'Keterangan awal',
            'is_active'       => true,
        ]);

        $updateData = [
            'nama_pendidikan' => 'Pendidikan To Edit Updated',
            'keterangan'      => 'Keterangan diperbarui',
            'is_active'       => 1,
        ];

        $response = $this->actingAs($admin)->put(route('pendidikan.update', $pendidikan->id_pendidikan), $updateData);
        $response->assertRedirect(route('pendidikan.index'));

        $pendidikan->refresh();
        $this->assertEquals('Pendidikan To Edit Updated', $pendidikan->nama_pendidikan);
        $this->assertEquals('Keterangan diperbarui', $pendidikan->keterangan);
    }

    public function test_super_admin_can_delete_pendidikan_via_ajax(): void
    {
        $admin = $this->getSuperAdmin();

        Pendidikan::where('nama_pendidikan', 'Pendidikan To Delete')->delete();

        $pendidikan = Pendidikan::create([
            'nama_pendidikan' => 'Pendidikan To Delete',
            'keterangan'      => 'Akan dihapus',
            'is_active'       => true,
        ]);

        $response = $this->actingAs($admin)
            ->delete(route('pendidikan.destroy', $pendidikan->id_pendidikan), [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseMissing('pendidikan', ['id_pendidikan' => $pendidikan->id_pendidikan]);
    }
}
