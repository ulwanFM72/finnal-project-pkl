<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ekstrakurikuler', function (Blueprint $table) {
            $table->increments('id_ekskul');
            $table->string('nama_ekskul', 100)->unique();
            $table->unsignedInteger('id_pembina');
            $table->timestamps();

            $table->foreign('id_pembina')->references('id_pembina')->on('pembina')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ekstrakurikuler');
    }
};
