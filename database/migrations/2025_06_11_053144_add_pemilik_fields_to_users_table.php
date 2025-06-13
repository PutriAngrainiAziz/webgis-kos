<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik')->nullable();
            $table->string('alamat')->nullable();
            $table->string('foto_ktp')->nullable(); // untuk upload file
            $table->enum('status_verifikasi', ['menunggu', 'disetujui', 'ditolak'])->nullable();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nik', 'alamat', 'foto_ktp', 'status_verifikasi']);
        });
    }
};
