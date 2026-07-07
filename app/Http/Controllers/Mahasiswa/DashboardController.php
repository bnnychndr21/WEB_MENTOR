<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\PengajuanMentoring;
use App\Models\Notifikasi;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $jumlahPengajuan = PengajuanMentoring::where('mahasiswa_id', $user->id)->count();
        $pengajuanPending = PengajuanMentoring::where('mahasiswa_id', $user->id)->where('status', 'pending')->count();
        $pengajuanDisetujui = PengajuanMentoring::where('mahasiswa_id', $user->id)->where('status', 'disetujui')->count();
        $pengajuanSelesai = PengajuanMentoring::where('mahasiswa_id', $user->id)->where('status', 'selesai')->count();

        $pengajuanTerbaru = PengajuanMentoring::where('mahasiswa_id', $user->id)
            ->with('mentorProfil.user', 'kategori')
            ->latest()
            ->take(5)
            ->get();

        $notifikasi = Notifikasi::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('mahasiswa.dashboard', compact(
            'jumlahPengajuan',
            'pengajuanPending',
            'pengajuanDisetujui',
            'pengajuanSelesai',
            'pengajuanTerbaru',
            'notifikasi'
        ));
    }
}
