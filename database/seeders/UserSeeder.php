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
            'name' => 'Mahasiswa Demo',
            'email' => 'mahasiswa@test.com',
            'password' => bcrypt('password'),
            'role' => 'mahasiswa',
        ]);

        \App\Models\User::create([
            'name' => 'Mentor Demo',
            'email' => 'mentor@test.com',
            'password' => bcrypt('password'),
            'role' => 'mentor',
        ]);

        $this->command->info('User seeder berhasil: mahasiswa@test.com / mentor@test.com (password: password)');
    }
}
