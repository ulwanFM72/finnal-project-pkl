<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembina', function (Blueprint $table) {
            $table->increments('id_pembina');
            $table->string('nama_pembina', 100);
            $table->string('nomor_handphone', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->unsignedInteger('id_user');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembina');
    }
};
