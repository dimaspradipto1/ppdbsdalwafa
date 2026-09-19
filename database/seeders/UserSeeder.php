<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
            ],
            [
                'name' => 'Admin PPDB',
                'email' => 'adminppdb@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin_ppdb',
            ],
            [
                'name' => 'Panitia Verifikasi',
                'email' => 'verifikator@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'verifikator',
            ],
            [
                'name' => 'Kepala Sekolah',
                'email' => 'kepsek@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'kepala_sekolah',
            ],
            [
                'name' => 'Bendahara',
                'email' => 'bendahara@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'bendahara',
            ],
            [
                'name' => 'Guru / Wali Kelas',
                'email' => 'guru@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'guru',
            ],
            [
                'name' => 'Calon Siswa / Orang Tua',
                'email' => 'pendaftar@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'pendaftar',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => $user['password'],
                    'role' => $user['role'],
                ]
            );
        }
    }
}
