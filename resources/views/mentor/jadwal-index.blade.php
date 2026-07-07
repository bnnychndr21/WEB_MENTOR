@extends('layouts.dashboard')

@section('title', 'Kelola Jadwal')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <p class="text-muted mb-0" style="font-size: .9rem;">
        <i class="bi bi-info-circle me-1"></i>Atur jadwal tersedia Anda. Mahasiswa dapat memilih slot yang tersedia saat mengajukan konsultasi.
    </p>
    <a href="{{ route('mentor.jadwal.create') }}" class="btn btn-primary rounded-pill">
        <i class="bi bi-plus-lg me-1"></i> Tambah Jadwal
    </a>
</div>

<div class="card content-card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <span><i class="bi bi-calendar-week me-2"></i>Daftar Jadwal</span>
        <span class="badge bg-primary rounded-pill">{{ $jadwals->total() }} jadwal</span>
    </div>
    <div class="card-body p-0">
        @if ($jadwals->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-calendar-plus" style="font-size: 3rem; color: #cbd5e1;"></i>
                <p class="mt-2 text-muted">Belum ada jadwal.</p>
                <a href="{{ route('mentor.jadwal.create') }}" class="btn btn-primary rounded-pill">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Jadwal
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="padding-left: 1.5rem;">Tanggal</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Status</th>
                            <th class="text-end" style="padding-right: 1.5rem;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwals as $j)
                            <tr>
                                <td style="padding-left: 1.5rem; font-weight: 500;">
                                    <i class="bi bi-calendar-event me-1 text-primary"></i>
                                    {{ \Carbon\Carbon::parse($j->tanggal)->isoFormat('dddd, D MMM YYYY') }}
                                </td>
                                <td>
                                    <span class="fw-semibold">{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}</span>
                                </td>
                                <td>
                                    <span class="fw-semibold">{{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</span>
                                </td>
                                <td>
                                    @if ($j->tersedia)
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill">
                                            <i class="bi bi-check-circle me-1"></i>Tersedia
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill">
                                            <i class="bi bi-clock me-1"></i>Dipesan
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end" style="padding-right: 1.5rem;">
                                    <a href="{{ route('mentor.jadwal.edit', $j->id) }}"
                                       class="btn btn-sm btn-outline-primary rounded-pill">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('mentor.jadwal.destroy', $j->id) }}"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill"
                                                data-confirm="Hapus jadwal ini?">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center p-3">
                {{ $jadwals->links() }}
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .pagination { margin-bottom: 0; }
    .page-link { border-radius: .5rem !important; margin: 0 2px; border: none; color: #1e293b; font-weight: 500; }
    .page-item.active .page-link { background: #0ea5e9; color: #fff; }
    .page-item.disabled .page-link { color: #94a3b8; background: transparent; }
</style>
@endpush
@endsection
