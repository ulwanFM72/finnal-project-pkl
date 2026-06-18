<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminExists = DB::table('user')->where('username', 'admin')->first();

        if (!$adminExists) {
            DB::table('user')->insert([
                'username'   => 'admin',
                'password'   => Hash::make('@dm!neskul2026'),
                'id_level'   => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
