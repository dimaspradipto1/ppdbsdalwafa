<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserManagementTest extends TestCase
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

    public function test_super_admin_can_access_users_index(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)->get(route('users.index'));
        $response->assertStatus(200);
        $response->assertSee('Manajemen Pengguna (Users)');
    }

    public function test_datatables_ajax_returns_users_json(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)
            ->get(route('users.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data'
        ]);
    }

    public function test_non_super_admin_cannot_access_users_index(): void
    {
        $guru = User::firstOrCreate(
            ['email' => 'guru@gmail.com'],
            [
                'name' => 'Guru',
                'password' => Hash::make('password'),
                'role' => 'guru',
            ]
        );

        $response = $this->actingAs($guru)->get(route('users.index'));
        $response->assertStatus(403);
    }

    public function test_super_admin_can_create_user(): void
    {
        $admin = $this->getSuperAdmin();

        User::where('email', 'panitiabaru@gmail.com')->delete();

        $userData = [
            'name'                  => 'Panitia Baru',
            'email'                 => 'panitiabaru@gmail.com',
            'role'                  => 'verifikator',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->actingAs($admin)->post(route('users.store'), $userData);
        $response->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'panitiabaru@gmail.com',
            'role'  => 'verifikator',
        ]);
    }

    public function test_super_admin_can_update_user_without_changing_password(): void
    {
        $admin = $this->getSuperAdmin();

        $user = User::updateOrCreate(
            ['email' => 'testedit@gmail.com'],
            [
                'name'     => 'Old Name',
                'password' => Hash::make('original-password'),
                'role'     => 'guru',
            ]
        );

        $oldPasswordHash = $user->password;

        // Update name and role, leave password empty
        $response = $this->actingAs($admin)->put(route('users.update', $user->id), [
            'name'                  => 'New Name',
            'email'                 => 'testedit@gmail.com',
            'role'                  => 'admin_ppdb',
            'password'              => '',
            'password_confirmation' => '',
        ]);

        $response->assertRedirect(route('users.index'));

        $user->refresh();
        $this->assertEquals('New Name', $user->name);
        $this->assertEquals('admin_ppdb', $user->role);
        $this->assertTrue(Hash::check('original-password', $user->password));
        $this->assertEquals($oldPasswordHash, $user->password);
    }

    public function test_super_admin_can_update_user_with_new_password(): void
    {
        $admin = $this->getSuperAdmin();

        $user = User::updateOrCreate(
            ['email' => 'testpassword@gmail.com'],
            [
                'name'     => 'User Password',
                'password' => Hash::make('old-secret'),
                'role'     => 'guru',
            ]
        );

        // Update with new password
        $response = $this->actingAs($admin)->put(route('users.update', $user->id), [
            'name'                  => 'User Password Updated',
            'email'                 => 'testpassword@gmail.com',
            'role'                  => 'guru',
            'password'              => 'new-secret-123',
            'password_confirmation' => 'new-secret-123',
        ]);

        $response->assertRedirect(route('users.index'));

        $user->refresh();
        $this->assertFalse(Hash::check('old-secret', $user->password));
        $this->assertTrue(Hash::check('new-secret-123', $user->password));
    }

    public function test_super_admin_cannot_delete_own_account(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)
            ->delete(route('users.destroy', $admin->id), [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(422);
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_super_admin_can_delete_other_user(): void
    {
        $admin = $this->getSuperAdmin();

        $user = User::create([
            'name'     => 'User to delete',
            'email'    => 'todelete@gmail.com',
            'password' => Hash::make('password'),
            'role'     => 'guru',
        ]);

        $response = $this->actingAs($admin)
            ->delete(route('users.destroy', $user->id), [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
