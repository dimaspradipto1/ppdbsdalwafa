<?php

namespace Tests\Feature;

use App\Models\Biaya;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BiayaTest extends TestCase
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

    public function test_super_admin_can_access_biaya_index(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)->get(route('biaya.index'));
        $response->assertStatus(200);
        $response->assertSee('Tarif & Biaya PPDB', false);
    }

    public function test_datatables_ajax_returns_biaya_json(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)
            ->get(route('biaya.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data',
        ]);
    }

    public function test_unauthorized_role_cannot_access_biaya(): void
    {
        $pendaftar = User::firstOrCreate(
            ['email' => 'pendaftar@gmail.com'],
            [
                'name'     => 'Pendaftar',
                'password' => Hash::make('password'),
                'role'     => 'pendaftar',
            ]
        );

        $response = $this->actingAs($pendaftar)->get(route('biaya.index'));
        $response->assertStatus(403);
    }

    public function test_store_biaya_validation(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)->post(route('biaya.store'), []);
        $response->assertSessionHasErrors(['nama_biaya', 'nominal', 'jenis_biaya']);
    }

    public function test_can_create_and_update_and_delete_biaya(): void
    {
        $admin = $this->getSuperAdmin();
        $tahun = TahunAjaran::first();

        // 1. Create
        $response = $this->actingAs($admin)->post(route('biaya.store'), [
            'id_tahun_ajaran' => $tahun?->id_tahun_ajaran,
            'nama_biaya'      => 'Biaya Asuransi Test',
            'jenis_biaya'     => 'lainnya',
            'nominal'         => 150000,
            'tipe_pembayaran' => 'sekali',
            'is_wajib'        => 1,
            'is_active'       => 1,
            'keterangan'      => 'Uji coba biaya',
        ]);

        $response->assertRedirect(route('biaya.index'));
        $this->assertDatabaseHas('biaya_ppdb', [
            'nama_biaya' => 'Biaya Asuransi Test',
            'nominal'    => 150000,
        ]);

        $biaya = Biaya::where('nama_biaya', 'Biaya Asuransi Test')->first();

        // 2. Update
        $updateResponse = $this->actingAs($admin)->put(route('biaya.update', $biaya->id_biaya), [
            'id_tahun_ajaran' => $tahun?->id_tahun_ajaran,
            'nama_biaya'      => 'Biaya Asuransi Diperbarui',
            'jenis_biaya'     => 'lainnya',
            'nominal'         => 200000,
            'tipe_pembayaran' => 'tahunan',
            'is_wajib'        => 1,
            'is_active'       => 1,
        ]);

        $updateResponse->assertRedirect(route('biaya.index'));
        $this->assertDatabaseHas('biaya_ppdb', [
            'id_biaya'   => $biaya->id_biaya,
            'nama_biaya' => 'Biaya Asuransi Diperbarui',
            'nominal'    => 200000,
        ]);

        // 3. Delete
        $deleteResponse = $this->actingAs($admin)->delete(route('biaya.destroy', $biaya->id_biaya));
        $deleteResponse->assertRedirect(route('biaya.index'));
        $this->assertDatabaseMissing('biaya_ppdb', [
            'id_biaya' => $biaya->id_biaya,
        ]);
    }
}
