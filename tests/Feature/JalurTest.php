<?php

namespace Tests\Feature;

use App\Models\Jalur;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class JalurTest extends TestCase
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

    public function test_super_admin_can_access_jalur_index(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)->get(route('jalur.index'));
        $response->assertStatus(200);
        $response->assertSee('Jalur Pendaftaran & Kuota', false);
    }

    public function test_datatables_ajax_returns_jalur_json(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)
            ->get(route('jalur.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data',
        ]);
    }

    public function test_unauthorized_role_cannot_access_jalur(): void
    {
        $pendaftar = User::firstOrCreate(
            ['email' => 'pendaftar@gmail.com'],
            [
                'name'     => 'Pendaftar',
                'password' => Hash::make('password'),
                'role'     => 'pendaftar',
            ]
        );

        $response = $this->actingAs($pendaftar)->get(route('jalur.index'));
        $response->assertStatus(403);
    }

    public function test_store_jalur_validation(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)->post(route('jalur.store'), []);
        $response->assertSessionHasErrors(['nama_jalur']);
    }

    public function test_can_create_and_update_and_delete_jalur(): void
    {
        $admin = $this->getSuperAdmin();
        $tahun = TahunAjaran::first();

        // 1. Create
        $response = $this->actingAs($admin)->post(route('jalur.store'), [
            'id_tahun_ajaran' => $tahun?->id_tahun_ajaran,
            'nama_jalur'      => 'Jalur Prestasi Tahfidz Test',
            'kode_jalur'      => 'PRESTASI_' . time(),
            'kuota'           => 15,
            'deskripsi'       => 'Khusus calon siswa berprestasi tahfidz',
            'is_active'       => 1,
        ]);

        $response->assertRedirect(route('jalur.index'));
        $this->assertDatabaseHas('jalur', [
            'nama_jalur' => 'Jalur Prestasi Tahfidz Test',
            'kuota'      => 15,
        ]);

        $jalur = Jalur::where('nama_jalur', 'Jalur Prestasi Tahfidz Test')->first();

        // 2. Update
        $updateResponse = $this->actingAs($admin)->put(route('jalur.update', $jalur->id_jalur), [
            'id_tahun_ajaran' => $tahun?->id_tahun_ajaran,
            'nama_jalur'      => 'Jalur Prestasi Tahfidz Diperbarui',
            'kode_jalur'      => $jalur->kode_jalur,
            'kuota'           => 20,
            'deskripsi'       => 'Deskripsi revisi',
            'is_active'       => 1,
        ]);

        $updateResponse->assertRedirect(route('jalur.index'));
        $this->assertDatabaseHas('jalur', [
            'id_jalur'   => $jalur->id_jalur,
            'nama_jalur' => 'Jalur Prestasi Tahfidz Diperbarui',
            'kuota'      => 20,
        ]);

        // 3. Delete
        $deleteResponse = $this->actingAs($admin)->delete(route('jalur.destroy', $jalur->id_jalur));
        $deleteResponse->assertRedirect(route('jalur.index'));
        $this->assertDatabaseMissing('jalur', [
            'id_jalur' => $jalur->id_jalur,
        ]);
    }
}
