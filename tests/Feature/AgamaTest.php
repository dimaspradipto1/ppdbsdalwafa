<?php

namespace Tests\Feature;

use App\Models\Agama;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AgamaTest extends TestCase
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

    public function test_super_admin_can_access_agama_index(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)->get(route('agama.index'));
        $response->assertStatus(200);
        $response->assertSee('Master Data Agama');
    }

    public function test_datatables_ajax_returns_agama_json(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)
            ->get(route('agama.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data'
        ]);
    }

    public function test_unauthorized_role_cannot_access_agama(): void
    {
        $pendaftar = User::firstOrCreate(
            ['email' => 'pendaftar@gmail.com'],
            [
                'name'     => 'Pendaftar',
                'password' => Hash::make('password'),
                'role'     => 'pendaftar',
            ]
        );

        $response = $this->actingAs($pendaftar)->get(route('agama.index'));
        $response->assertStatus(403);
    }

    public function test_super_admin_can_create_agama(): void
    {
        $admin = $this->getSuperAdmin();

        Agama::where('nama_agama', 'Test Agama Baru')->delete();

        $data = [
            'nama_agama' => 'Test Agama Baru',
            'keterangan' => 'Keterangan uji coba',
            'is_active'  => 1,
        ];

        $response = $this->actingAs($admin)->post(route('agama.store'), $data);
        $response->assertRedirect(route('agama.index'));

        $this->assertDatabaseHas('agama', [
            'nama_agama' => 'Test Agama Baru',
            'is_active'  => true,
        ]);
    }

    public function test_super_admin_can_update_agama(): void
    {
        $admin = $this->getSuperAdmin();

        Agama::whereIn('nama_agama', ['Agama To Edit', 'Agama To Edit Updated'])->delete();

        $agama = Agama::create([
            'nama_agama' => 'Agama To Edit',
            'keterangan' => 'Keterangan awal',
            'is_active'  => true,
        ]);

        $updateData = [
            'nama_agama' => 'Agama To Edit Updated',
            'keterangan' => 'Keterangan diperbarui',
            'is_active'  => 1,
        ];

        $response = $this->actingAs($admin)->put(route('agama.update', $agama->id_agama), $updateData);
        $response->assertRedirect(route('agama.index'));

        $agama->refresh();
        $this->assertEquals('Agama To Edit Updated', $agama->nama_agama);
        $this->assertEquals('Keterangan diperbarui', $agama->keterangan);
    }

    public function test_super_admin_can_delete_agama_via_ajax(): void
    {
        $admin = $this->getSuperAdmin();

        Agama::where('nama_agama', 'Agama To Delete')->delete();

        $agama = Agama::create([
            'nama_agama' => 'Agama To Delete',
            'keterangan' => 'Akan dihapus',
            'is_active'  => true,
        ]);

        $response = $this->actingAs($admin)
            ->delete(route('agama.destroy', $agama->id_agama), [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseMissing('agama', ['id_agama' => $agama->id_agama]);
    }
}
