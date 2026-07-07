<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\UlasanRequest;
use App\Models\PengajuanMentoring;
use App\Models\Ulasan;
use Illuminate\Http\RedirectResponse;

class UlasanController extends Controller
{
    public function store(UlasanRequest $request, PengajuanMentoring $pengajuan): RedirectResponse
    {
        Ulasan::create([
            'pengajuan_id' => $pengajuan->id,
            'mahasiswa_id' => auth()->id(),
            'mentor_id' => $pengajuan->mentor_id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect()->back()->with('success', 'Rating dan ulasan berhasil dikirim.');
    }
}
