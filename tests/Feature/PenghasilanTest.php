<?php

namespace Tests\Feature;

use App\Models\Penghasilan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PenghasilanTest extends TestCase
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

    public function test_super_admin_can_access_penghasilan_index(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)->get(route('penghasilan.index'));
        $response->assertStatus(200);
        $response->assertSee('Master Data Penghasilan');
    }

    public function test_datatables_ajax_returns_penghasilan_json(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)
            ->get(route('penghasilan.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data'
        ]);
    }

    public function test_unauthorized_role_cannot_access_penghasilan(): void
    {
        $pendaftar = User::firstOrCreate(
            ['email' => 'pendaftar@gmail.com'],
            [
                'name'     => 'Pendaftar',
                'password' => Hash::make('password'),
                'role'     => 'pendaftar',
            ]
        );

        $response = $this->actingAs($pendaftar)->get(route('penghasilan.index'));
        $response->assertStatus(403);
    }

    public function test_super_admin_can_create_penghasilan(): void
    {
        $admin = $this->getSuperAdmin();

        Penghasilan::where('label', 'Penghasilan Uji Coba')->delete();

        $data = [
            'label'       => 'Penghasilan Uji Coba',
            'batas_bawah' => 3000000,
            'batas_atas'  => 5000000,
            'urutan'      => 10,
            'is_active'   => 1,
        ];

        $response = $this->actingAs($admin)->post(route('penghasilan.store'), $data);
        $response->assertRedirect(route('penghasilan.index'));

        $this->assertDatabaseHas('ref_penghasilan', [
            'label'       => 'Penghasilan Uji Coba',
            'batas_bawah' => 3000000,
            'batas_atas'  => 5000000,
            'is_active'   => true,
        ]);
    }

    public function test_super_admin_can_update_penghasilan(): void
    {
        $admin = $this->getSuperAdmin();

        Penghasilan::whereIn('label', ['Penghasilan To Edit', 'Penghasilan To Edit Updated'])->delete();

        $penghasilan = Penghasilan::create([
            'label'       => 'Penghasilan To Edit',
            'batas_bawah' => 1000000,
            'batas_atas'  => 2000000,
            'urutan'      => 1,
            'is_active'   => true,
        ]);

        $updateData = [
            'label'       => 'Penghasilan To Edit Updated',
            'batas_bawah' => 1500000,
            'batas_atas'  => 2500000,
            'urutan'      => 2,
            'is_active'   => 1,
        ];

        $response = $this->actingAs($admin)->put(route('penghasilan.update', $penghasilan->id_penghasilan), $updateData);
        $response->assertRedirect(route('penghasilan.index'));

        $penghasilan->refresh();
        $this->assertEquals('Penghasilan To Edit Updated', $penghasilan->label);
        $this->assertEquals('1500000.00', $penghasilan->batas_bawah);
        $this->assertEquals('2500000.00', $penghasilan->batas_atas);
    }

    public function test_super_admin_can_delete_penghasilan_via_ajax(): void
    {
        $admin = $this->getSuperAdmin();

        Penghasilan::where('label', 'Penghasilan To Delete')->delete();

        $penghasilan = Penghasilan::create([
            'label'       => 'Penghasilan To Delete',
            'batas_bawah' => 500000,
            'batas_atas'  => 1000000,
            'urutan'      => 99,
            'is_active'   => true,
        ]);

        $response = $this->actingAs($admin)
            ->delete(route('penghasilan.destroy', $penghasilan->id_penghasilan), [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseMissing('ref_penghasilan', ['id_penghasilan' => $penghasilan->id_penghasilan]);
    }
}
