<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('level', function (Blueprint $table) {
            $table->increments('id_level');
            $table->string('nama_level', 100)->nullable();
        });

        // Seeder data
        DB::table('level')->insert([
            ['id_level' => 1, 'nama_level' => 'siswa'],
            ['id_level' => 2, 'nama_level' => 'pembina'],
            ['id_level' => 3, 'nama_level' => 'admin'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('level');
    }
};
