<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'name')) {
                $table->renameColumn('name', 'nama');
            }
            if (Schema::hasColumn('users', 'password')) {
                $table->renameColumn('password', 'kata_sandi');
            }
            if (Schema::hasColumn('users', 'role')) {
                $table->renameColumn('role', 'peran');
            }
            if (!Schema::hasIndex('users', 'users_peran_index')) {
                $table->index('peran');
            }
        });

        Schema::table('chats', function (Blueprint $table) {
            if (Schema::hasColumn('chats', 'message')) {
                $table->renameColumn('message', 'pesan');
            }
        });

        Schema::table('notifikasis', function (Blueprint $table) {
            if (Schema::hasColumn('notifikasis', 'is_read')) {
                $table->renameColumn('is_read', 'dibaca');
            }
        });

        Schema::table('pengajuan_mentorings', function (Blueprint $table) {
            if (!Schema::hasIndex('pengajuan_mentorings', 'pengajuan_mentorings_status_index')) {
                $table->index('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasIndex('users', 'users_peran_index')) {
                $table->dropIndex(['peran']);
            }
            if (Schema::hasColumn('users', 'peran')) {
                $table->renameColumn('peran', 'role');
            }
            if (Schema::hasColumn('users', 'kata_sandi')) {
                $table->renameColumn('kata_sandi', 'password');
            }
            if (Schema::hasColumn('users', 'nama')) {
                $table->renameColumn('nama', 'name');
            }
        });

        Schema::table('chats', function (Blueprint $table) {
            if (Schema::hasColumn('chats', 'pesan')) {
                $table->renameColumn('pesan', 'message');
            }
        });

        Schema::table('notifikasis', function (Blueprint $table) {
            if (Schema::hasColumn('notifikasis', 'dibaca')) {
                $table->renameColumn('dibaca', 'is_read');
            }
        });

        Schema::table('pengajuan_mentorings', function (Blueprint $table) {
            if (Schema::hasIndex('pengajuan_mentorings', 'pengajuan_mentorings_status_index')) {
                $table->dropIndex(['status']);
            }
        });
    }
};
