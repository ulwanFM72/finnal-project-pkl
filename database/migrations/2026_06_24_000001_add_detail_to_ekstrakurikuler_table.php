<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::table('ekstrakurikuler', function (Blueprint $table) {
      $table->string('foto', 100)->nullable()->after('id_pembina');
      $table->string('jadwal', 100)->nullable()->after('foto');
      $table->text('deskripsi')->nullable()->after('jadwal');
    });
  }

  public function down(): void
  {
    Schema::table('ekstrakurikuler', function (Blueprint $table) {
      $table->dropColumn(['foto', 'jadwal', 'deskripsi']);
    });
  }
};
