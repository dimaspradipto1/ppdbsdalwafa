<?php

namespace Tests\Feature;

use App\Models\JenisDokumen;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PersyaratanDokumenTest extends TestCase
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

    public function test_super_admin_can_access_persyaratan_dokumen_index(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)->get(route('persyaratan-dokumen.index'));
        $response->assertStatus(200);
        $response->assertSee('Persyaratan Dokumen');
    }

    public function test_datatables_ajax_returns_persyaratan_dokumen_json(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)
            ->get(route('persyaratan-dokumen.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data',
        ]);
    }

    public function test_unauthorized_role_cannot_access_persyaratan_dokumen(): void
    {
        $pendaftar = User::firstOrCreate(
            ['email' => 'pendaftar@gmail.com'],
            [
                'name'     => 'Pendaftar',
                'password' => Hash::make('password'),
                'role'     => 'pendaftar',
            ]
        );

        $response = $this->actingAs($pendaftar)->get(route('persyaratan-dokumen.index'));
        $response->assertStatus(403);
    }

    public function test_store_persyaratan_dokumen_validation(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)->post(route('persyaratan-dokumen.store'), []);
        $response->assertSessionHasErrors(['kode', 'nama_dokumen', 'kategori']);
    }

    public function test_can_create_and_update_and_delete_persyaratan_dokumen(): void
    {
        $admin = $this->getSuperAdmin();

        // 1. Create
        $response = $this->actingAs($admin)->post(route('persyaratan-dokumen.store'), [
            'kode'          => 'TEST_DOK_' . time(),
            'nama_dokumen'  => 'Surat Pernyataan Uji Coba',
            'kategori'      => 'semua',
            'jumlah_lembar' => '1 Lembar Asli',
            'is_wajib'      => 1,
            'is_active'     => 1,
        ]);

        $response->assertRedirect(route('persyaratan-dokumen.index'));
        $this->assertDatabaseHas('ref_jenis_dokumen', [
            'nama_dokumen' => 'Surat Pernyataan Uji Coba',
            'kategori'     => 'semua',
        ]);

        $dokumen = JenisDokumen::where('nama_dokumen', 'Surat Pernyataan Uji Coba')->first();

        // 2. Update
        $updateResponse = $this->actingAs($admin)->put(route('persyaratan-dokumen.update', $dokumen->id_jenis_dokumen), [
            'kode'          => $dokumen->kode,
            'nama_dokumen'  => 'Surat Pernyataan Diperbarui',
            'kategori'      => 'siswa_baru',
            'jumlah_lembar' => '2 Lembar',
            'is_wajib'      => 0,
            'is_active'     => 1,
        ]);

        $updateResponse->assertRedirect(route('persyaratan-dokumen.index'));
        $this->assertDatabaseHas('ref_jenis_dokumen', [
            'id_jenis_dokumen' => $dokumen->id_jenis_dokumen,
            'nama_dokumen'     => 'Surat Pernyataan Diperbarui',
            'kategori'         => 'siswa_baru',
        ]);

        // 3. Delete
        $deleteResponse = $this->actingAs($admin)->delete(route('persyaratan-dokumen.destroy', $dokumen->id_jenis_dokumen));
        $deleteResponse->assertRedirect(route('persyaratan-dokumen.index'));
        $this->assertDatabaseMissing('ref_jenis_dokumen', [
            'id_jenis_dokumen' => $dokumen->id_jenis_dokumen,
        ]);
    }
}
