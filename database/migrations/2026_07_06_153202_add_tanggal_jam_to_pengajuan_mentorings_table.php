<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuan_mentorings', function (Blueprint $table) {
            $table->date('tanggal')->nullable()->after('deskripsi');
            $table->time('jam')->nullable()->after('tanggal');
        });
    }

    public function down(): void
    {
        Schema::table('pengajuan_mentorings', function (Blueprint $table) {
            $table->dropColumn(['tanggal', 'jam']);
        });
    }
};
