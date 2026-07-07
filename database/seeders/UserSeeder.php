<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'nama' => 'Mahasiswa Demo',
            'email' => 'mahasiswa@test.com',
            'kata_sandi' => bcrypt('password'),
            'peran' => 'mahasiswa',
        ]);

        \App\Models\User::create([
            'nama' => 'Mentor Demo',
            'email' => 'mentor@test.com',
            'kata_sandi' => bcrypt('password'),
            'peran' => 'mentor',
        ]);

        $this->command->info('User seeder berhasil: mahasiswa@test.com / mentor@test.com (password: password)');
    }
}
