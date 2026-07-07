<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keahlians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained('mentor_profils')->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('kategori_keahlians')->onDelete('cascade');
            $table->enum('tingkat_keahlian', ['pemula', 'menengah', 'ahli'])->default('menengah');
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->unique(['mentor_id', 'kategori_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keahlians');
    }
};
