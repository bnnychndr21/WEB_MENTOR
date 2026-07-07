<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_mentorings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('mentor_id')->constrained('mentor_profils')->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('kategori_keahlians')->onDelete('restrict');
            $table->string('judul', 200);
            $table->text('deskripsi');
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'selesai', 'dibatalkan'])->default('pending');
            $table->text('catatan_mentor')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_mentorings');
    }
};
