<?php

namespace Tests\Feature;

use App\Models\KomponenSeleksi;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class KomponenSeleksiTest extends TestCase
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

    public function test_super_admin_can_access_komponen_seleksi_index(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)->get(route('komponen-seleksi.index'));
        $response->assertStatus(200);
        $response->assertSee('Komponen & Kriteria Seleksi', false);
    }

    public function test_datatables_ajax_returns_komponen_seleksi_json(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)
            ->get(route('komponen-seleksi.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data',
        ]);
    }

    public function test_unauthorized_role_cannot_access_komponen_seleksi(): void
    {
        $pendaftar = User::firstOrCreate(
            ['email' => 'pendaftar@gmail.com'],
            [
                'name'     => 'Pendaftar',
                'password' => Hash::make('password'),
                'role'     => 'pendaftar',
            ]
        );

        $response = $this->actingAs($pendaftar)->get(route('komponen-seleksi.index'));
        $response->assertStatus(403);
    }

    public function test_store_komponen_seleksi_validation(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)->post(route('komponen-seleksi.store'), []);
        $response->assertSessionHasErrors(['nama_komponen']);
    }

    public function test_can_create_and_update_and_delete_komponen_seleksi(): void
    {
        $admin = $this->getSuperAdmin();

        // 1. Create
        $response = $this->actingAs($admin)->post(route('komponen-seleksi.store'), [
            'nama_komponen' => 'Tes Bakat Minat Uji Coba',
            'kode'          => 'TBM',
            'nilai_minimal' => 70.00,
            'bobot_persen'  => 20,
            'urutan'        => 5,
            'is_active'     => 1,
            'keterangan'    => 'Observasi bakat anak',
        ]);

        $response->assertRedirect(route('komponen-seleksi.index'));
        $this->assertDatabaseHas('komponen_seleksi', [
            'nama_komponen' => 'Tes Bakat Minat Uji Coba',
            'bobot_persen'  => 20,
        ]);

        $komponen = KomponenSeleksi::where('nama_komponen', 'Tes Bakat Minat Uji Coba')->first();

        // 2. Update
        $updateResponse = $this->actingAs($admin)->put(route('komponen-seleksi.update', $komponen->id_komponen_seleksi), [
            'nama_komponen' => 'Tes Bakat Minat Diperbarui',
            'kode'          => 'TBM_REV',
            'nilai_minimal' => 75.00,
            'bobot_persen'  => 25,
            'urutan'        => 5,
            'is_active'     => 1,
        ]);

        $updateResponse->assertRedirect(route('komponen-seleksi.index'));
        $this->assertDatabaseHas('komponen_seleksi', [
            'id_komponen_seleksi' => $komponen->id_komponen_seleksi,
            'nama_komponen'       => 'Tes Bakat Minat Diperbarui',
            'bobot_persen'        => 25,
        ]);

        // 3. Delete
        $deleteResponse = $this->actingAs($admin)->delete(route('komponen-seleksi.destroy', $komponen->id_komponen_seleksi));
        $deleteResponse->assertRedirect(route('komponen-seleksi.index'));
        $this->assertDatabaseMissing('komponen_seleksi', [
            'id_komponen_seleksi' => $komponen->id_komponen_seleksi,
        ]);
    }
}
