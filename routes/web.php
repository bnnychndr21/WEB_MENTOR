<?php

use App\Http\Controllers\Mahasiswa\CariMentorController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboard;
use App\Http\Controllers\Mahasiswa\PengajuanController as MahasiswaPengajuan;
use App\Http\Controllers\Mahasiswa\ProfilController as MahasiswaProfil;
use App\Http\Controllers\Mahasiswa\UlasanController as MahasiswaUlasan;
use App\Http\Controllers\Mentor\DashboardController as MentorDashboard;
use App\Http\Controllers\Mentor\JadwalController as MentorJadwal;
use App\Http\Controllers\Mentor\PengajuanController as MentorPengajuan;
use App\Http\Controllers\Mentor\ProfilController as MentorProfil;
use App\Http\Controllers\Mentor\UlasanController as MentorUlasan;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return redirect($user->peran === 'mentor' ? route('mentor.dashboard') : route('mahasiswa.dashboard'));
    }
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user) {
        return redirect($user->peran === 'mentor' ? route('mentor.dashboard') : route('mahasiswa.dashboard'));
    }
    return redirect('/login');
})->middleware('auth');

Route::middleware(['auth'])->group(function () {

    Route::middleware('mahasiswa')->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', [MahasiswaDashboard::class, 'index'])->name('dashboard');
        Route::get('/cari-mentor', [CariMentorController::class, 'index'])->name('cari-mentor');
        Route::get('/mentor/{mentor}', [CariMentorController::class, 'show'])->name('mentor.show');
        Route::get('/pengajuan', [MahasiswaPengajuan::class, 'index'])->name('pengajuan.index');
        Route::get('/pengajuan/create/{mentor}', [MahasiswaPengajuan::class, 'create'])->name('pengajuan.create');
        Route::post('/pengajuan', [MahasiswaPengajuan::class, 'store'])->name('pengajuan.store');
        Route::get('/profil', [MahasiswaProfil::class, 'show'])->name('profil');
        Route::get('/profil/edit', [MahasiswaProfil::class, 'edit'])->name('profil.edit');
        Route::put('/profil', [MahasiswaProfil::class, 'update'])->name('profil.update');
        Route::post('/ulasan/{pengajuan}', [MahasiswaUlasan::class, 'store'])->name('ulasan.store');
    });

    Route::middleware('mentor')->prefix('mentor')->name('mentor.')->group(function () {
        Route::get('/dashboard', [MentorDashboard::class, 'index'])->name('dashboard');
        Route::get('/jadwal', [MentorJadwal::class, 'index'])->name('jadwal.index');
        Route::get('/jadwal/create', [MentorJadwal::class, 'create'])->name('jadwal.create');
        Route::post('/jadwal', [MentorJadwal::class, 'store'])->name('jadwal.store');
        Route::get('/jadwal/{jadwal}/edit', [MentorJadwal::class, 'edit'])->name('jadwal.edit');
        Route::put('/jadwal/{jadwal}', [MentorJadwal::class, 'update'])->name('jadwal.update');
        Route::delete('/jadwal/{jadwal}', [MentorJadwal::class, 'destroy'])->name('jadwal.destroy');
        Route::get('/pengajuan', [MentorPengajuan::class, 'index'])->name('pengajuan.index');
        Route::get('/pengajuan/{pengajuan}', [MentorPengajuan::class, 'show'])->name('pengajuan.show');
        Route::post('/pengajuan/{pengajuan}/terima', [MentorPengajuan::class, 'terima'])->name('pengajuan.terima');
        Route::post('/pengajuan/{pengajuan}/tolak', [MentorPengajuan::class, 'tolak'])->name('pengajuan.tolak');
        Route::post('/pengajuan/{pengajuan}/selesai', [MentorPengajuan::class, 'selesai'])->name('pengajuan.selesai');
        Route::get('/ulasan', [MentorUlasan::class, 'index'])->name('ulasan.index');
        Route::get('/profil', [MentorProfil::class, 'show'])->name('profil');
        Route::get('/profil/edit', [MentorProfil::class, 'edit'])->name('profil.edit');
        Route::put('/profil', [MentorProfil::class, 'update'])->name('profil.update');
    });

    Route::get('/notifikasi/{notifikasi}/baca', [NotifikasiController::class, 'baca'])->name('notifikasi.baca');

    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/{pengajuan}', [ChatController::class, 'index'])->name('index');
        Route::get('/{pengajuan}/fetch', [ChatController::class, 'fetch'])->name('fetch');
        Route::post('/{pengajuan}/send', [ChatController::class, 'send'])->name('send');
    });

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
