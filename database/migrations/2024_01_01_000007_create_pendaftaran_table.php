<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->increments('id_pendaftaran');
            $table->unsignedInteger('id_siswa');
            $table->unsignedInteger('id_ekskul');
            $table->date('tanggal_daftar');
            $table->timestamps();

            $table->unique(['id_siswa', 'id_ekskul']); // cegah daftar duplikat
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
            $table->foreign('id_ekskul')->references('id_ekskul')->on('ekstrakurikuler')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
