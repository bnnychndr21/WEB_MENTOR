<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalController extends Controller
{
    public function index(): View
    {
        $profil = auth()->user()->mentorProfil;
        abort_unless($profil, 403, 'Lengkapi profil mentor terlebih dahulu.');

        $jadwals = Jadwal::where('mentor_id', $profil->id)
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->paginate(15);

        return view('mentor.jadwal-index', compact('jadwals'));
    }

    public function create(): View
    {
        return view('mentor.jadwal-form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ], [
            'tanggal.required' => 'Tanggal harus diisi.',
            'tanggal.after_or_equal' => 'Tanggal tidak boleh sebelum hari ini.',
            'jam_mulai.required' => 'Jam mulai harus diisi.',
            'jam_selesai.required' => 'Jam selesai harus diisi.',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
        ]);

        $data['mentor_id'] = auth()->user()->mentorProfil->id;

        Jadwal::create($data);

        return redirect()->route('mentor.jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Jadwal $jadwal): View
    {
        $profil = auth()->user()->mentorProfil;
        abort_unless($profil, 403);
        abort_if($jadwal->mentor_id !== $profil->id, 403);

        return view('mentor.jadwal-form', compact('jadwal'));
    }

    public function update(Request $request, Jadwal $jadwal): RedirectResponse
    {
        $profil = auth()->user()->mentorProfil;
        abort_unless($profil, 403);
        abort_if($jadwal->mentor_id !== $profil->id, 403);

        $data = $request->validate([
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $jadwal->update($data);

        return redirect()->route('mentor.jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Jadwal $jadwal): RedirectResponse
    {
        $profil = auth()->user()->mentorProfil;
        abort_unless($profil, 403);
        abort_if($jadwal->mentor_id !== $profil->id, 403);

        $jadwal->delete();

        return redirect()->route('mentor.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}
