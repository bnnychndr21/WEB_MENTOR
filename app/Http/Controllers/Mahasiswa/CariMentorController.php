<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\KategoriKeahlian;
use App\Models\MentorProfil;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CariMentorController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->search;
        $kategoriId = $request->kategori;
        $perPage = 9;

        $query = DB::table('mentor_profils')
            ->select('mentor_profils.id', 'mentor_profils.user_id')
            ->join('users', 'users.id', '=', 'mentor_profils.user_id')
            ->leftJoin('keahlians', 'keahlians.mentor_id', '=', 'mentor_profils.id')
            ->leftJoin('kategori_keahlians', 'kategori_keahlians.id', '=', 'keahlians.kategori_id')
            ->where('users.role', 'mentor');

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('users.name', 'like', "%{$keyword}%")
                  ->orWhere('kategori_keahlians.nama', 'like', "%{$keyword}%")
                  ->orWhere('mentor_profils.universitas', 'like', "%{$keyword}%")
                  ->orWhere('mentor_profils.perusahaan', 'like', "%{$keyword}%")
                  ->orWhere('mentor_profils.pengalaman', 'like', "%{$keyword}%");
            });
        }

        if ($kategoriId) {
            $query->where('keahlians.kategori_id', $kategoriId);
        }

        $idsQuery = $query->distinct()->select('mentor_profils.id');

        $mentors = MentorProfil::with(['user', 'keahlians.kategori'])
            ->whereIn('id', $idsQuery)
            ->paginate($perPage);

        $kategoris = KategoriKeahlian::orderBy('nama')->get();

        return view('mahasiswa.cari-mentor', compact('mentors', 'keyword', 'kategoriId', 'kategoris'));
    }

    public function show(MentorProfil $mentor)
    {
        $mentor->load(['user', 'keahlians.kategori']);

        $ulasans = Ulasan::where('mentor_id', $mentor->id)
            ->with('mahasiswa', 'pengajuan')
            ->latest()
            ->take(10)
            ->get();

        return view('mahasiswa.mentor-profil', compact('mentor', 'ulasans'));
    }
}
