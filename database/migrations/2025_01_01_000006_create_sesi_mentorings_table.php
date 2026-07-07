<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sesi_mentorings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuan_mentorings')->onDelete('cascade');
            $table->string('judul_sesi', 200)->nullable();
            $table->dateTime('jadwal');
            $table->smallInteger('durasi_menit')->unsigned()->default(60);
            $table->string('link_meeting', 255)->nullable();
            $table->enum('status', ['dijadwalkan', 'berlangsung', 'selesai', 'dibatalkan'])->default('dijadwalkan');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sesi_mentorings');
    }
};
