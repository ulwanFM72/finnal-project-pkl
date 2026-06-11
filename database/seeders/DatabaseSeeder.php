<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun admin default jika belum ada
        $adminExists = DB::table('user')->where('username', 'admin')->first();

        if (!$adminExists) {
            DB::table('user')->insert([
                'username'   => 'admin',
                'password'   => Hash::make('admin123'), // FIX: pakai Hash::make()
                'id_level'   => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
