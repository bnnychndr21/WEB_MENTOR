<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mentor_profils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('gelar', 100)->nullable();
            $table->string('universitas', 100);
            $table->year('tahun_lulus')->nullable();
            $table->string('pekerjaan', 100)->nullable();
            $table->string('perusahaan', 100)->nullable();
            $table->text('pengalaman')->nullable();
            $table->text('bio')->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->string('foto', 255)->nullable();
            $table->enum('status_verifikasi', ['terverifikasi', 'belum'])->default('belum');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mentor_profils');
    }
};
