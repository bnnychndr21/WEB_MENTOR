@extends('layouts.dashboard')

@section('title', 'Detail Pengajuan')

@section('content')
<div class="row g-4">
    <div class="col-12 col-lg-8">
        <div class="card content-card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-file-text-fill"></i> Detail Pengajuan
                @php
                    $statusMap = [
                        'pending' => ['label' => 'Menunggu', 'class' => 'badge-pending'],
                        'disetujui' => ['label' => 'Disetujui', 'class' => 'badge-disetujui'],
                        'ditolak' => ['label' => 'Ditolak', 'class' => 'badge-ditolak'],
                        'selesai' => ['label' => 'Selesai', 'class' => 'badge-selesai'],
                        'dibatalkan' => ['label' => 'Dibatalkan', 'class' => 'badge-ditolak'],
                    ];
                    $s = $statusMap[$pengajuan->status] ?? ['label' => ucfirst($pengajuan->status), 'class' => 'badge-pending'];
                @endphp
                <span class="badge-status ms-auto {{ $s['class'] }}">{{ $s['label'] }}</span>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-12 col-sm-6">
                        <label class="text-muted d-block" style="font-size: .8rem;">Mahasiswa</label>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            @php $mhsFoto = $pengajuan->mahasiswa->mahasiswaProfil?->foto; @endphp
                            @if ($mhsFoto)
                                <img src="{{ asset('storage/' . $mhsFoto) }}"
                                     style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
                            @else
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center"
                                     style="width: 36px; height: 36px; font-size: .8rem; font-weight: 600;">
                                    {{ strtoupper(substr($pengajuan->mahasiswa->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <span class="fw-semibold">{{ $pengajuan->mahasiswa->name }}</span>
                                <div class="text-muted" style="font-size: .8rem;">{{ $pengajuan->mahasiswa->email }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="text-muted d-block" style="font-size: .8rem;">Topik</label>
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill mt-1">
                            {{ $pengajuan->judul }}
                        </span>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="text-muted d-block" style="font-size: .8rem;">Tanggal</label>
                        <span class="fw-semibold">
                            {{ $pengajuan->tanggal ? \Carbon\Carbon::parse($pengajuan->tanggal)->isoFormat('D MMMM YYYY') : '—' }}
                        </span>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="text-muted d-block" style="font-size: .8rem;">Jam</label>
                        <span class="fw-semibold">
                            {{ $pengajuan->jam ? \Carbon\Carbon::parse($pengajuan->jam)->format('H:i') : '—' }}
                        </span>
                    </div>
                    <div class="col-12">
                        <label class="text-muted d-block" style="font-size: .8rem;">Deskripsi</label>
                        <p class="mb-0 mt-1" style="font-size: .9rem; white-space: pre-wrap;">{{ $pengajuan->deskripsi }}</p>
                    </div>
                    @if ($pengajuan->catatan_mentor)
                        <div class="col-12">
                            <label class="text-muted d-block" style="font-size: .8rem;">Catatan Mentor</label>
                            <p class="mb-0 mt-1" style="font-size: .9rem; white-space: pre-wrap;">{{ $pengajuan->catatan_mentor }}</p>
                        </div>
                    @endif
                    <div class="col-12">
                        <label class="text-muted d-block" style="font-size: .8rem;">Tanggal Pengajuan</label>
                        <span class="fw-semibold" style="font-size: .9rem;">
                            {{ \Carbon\Carbon::parse($pengajuan->created_at)->isoFormat('D MMMM YYYY, HH:mm') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4">
        <div class="card content-card">
            <div class="card-header">
                <i class="bi bi-gear-fill me-2"></i>Aksi
            </div>
            <div class="card-body">
                @if ($pengajuan->status === 'pending')
                    <p class="text-muted" style="font-size: .9rem;">
                        Pengajuan ini sedang menunggu keputusan Anda.
                    </p>
                    <form method="POST" action="{{ route('mentor.pengajuan.terima', $pengajuan->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 rounded-pill mb-2"
                                data-confirm="Terima pengajuan ini?">
                            <i class="bi bi-check-lg me-1"></i> Terima
                        </button>
                    </form>
                    <button type="button" class="btn btn-danger w-100 rounded-pill"
                            data-bs-toggle="modal" data-bs-target="#tolakModal">
                        <i class="bi bi-x-lg me-1"></i> Tolak
                    </button>

                    {{-- Modal Tolak --}}
                    <div class="modal fade" id="tolakModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content" style="border-radius: 1rem; border: none;">
                                <form method="POST" action="{{ route('mentor.pengajuan.tolak', $pengajuan->id) }}">
                                    @csrf
                                    <div class="modal-header border-0" style="padding: 1.25rem 1.5rem 0;">
                                        <h6 class="modal-title fw-bold">Tolak Pengajuan</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body" style="padding: 1rem 1.5rem;">
                                        <p class="text-muted mb-3" style="font-size: .9rem;">
                                            Tolak pengajuan dari <strong>{{ $pengajuan->mahasiswa->name }}</strong>?
                                        </p>
                                        <label class="form-label fw-semibold" style="font-size: .85rem;">
                                            Alasan Penolakan (opsional)
                                        </label>
                                        <textarea name="catatan_mentor" rows="3" class="form-control"
                                                  placeholder="Berikan alasan mengapa ditolak...">{{ old('catatan_mentor') }}</textarea>
                                    </div>
                                    <div class="modal-footer border-0" style="padding: 0 1.5rem 1.25rem;">
                                        <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger rounded-pill px-4">Ya, Tolak</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @elseif ($pengajuan->status === 'disetujui')
                    <div class="text-center py-3">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center mx-auto mb-2"
                             style="width: 56px; height: 56px; font-size: 1.5rem;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <p class="fw-semibold mb-0" style="font-size: .9rem;">Pengajuan telah diterima</p>
                        <p class="text-muted" style="font-size: .8rem;">Anda telah menyetujui pengajuan ini.</p>
                    </div>
                    <a href="{{ route('chat.index', $pengajuan->id) }}"
                       class="btn btn-primary rounded-pill w-100 mt-2">
                        <i class="bi bi-chat-dots-fill me-1"></i> Buka Chat
                    </a>
                    <form method="POST" action="{{ route('mentor.pengajuan.selesai', $pengajuan->id) }}" class="mt-2">
                        @csrf
                        <button type="submit" class="btn btn-success rounded-pill w-100"
                                data-confirm="Selesaikan konsultasi ini? Mahasiswa akan bisa memberikan rating.">
                            <i class="bi bi-check2-all me-1"></i> Selesaikan Konsultasi
                        </button>
                    </form>
                @elseif ($pengajuan->status === 'selesai')
                    <div class="text-center py-3">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center mx-auto mb-2"
                             style="width: 56px; height: 56px; font-size: 1.5rem;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <p class="fw-semibold mb-0" style="font-size: .9rem;">Konsultasi selesai</p>
                    </div>
                    <a href="{{ route('chat.index', $pengajuan->id) }}"
                       class="btn btn-primary rounded-pill w-100 mt-2">
                        <i class="bi bi-chat-dots-fill me-1"></i> Lihat Chat
                    </a>
                @elseif ($pengajuan->status === 'ditolak')
                    <div class="text-center py-3">
                        <div class="rounded-circle bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center mx-auto mb-2"
                             style="width: 56px; height: 56px; font-size: 1.5rem;">
                            <i class="bi bi-x-circle-fill"></i>
                        </div>
                        <p class="fw-semibold mb-0" style="font-size: .9rem;">Pengajuan ditolak</p>
                        <p class="text-muted" style="font-size: .8rem;">Anda telah menolak pengajuan ini.</p>
                    </div>
                @else
                    <div class="text-center py-3">
                        <span class="badge-status {{ $s['class'] }}">{{ $s['label'] }}</span>
                    </div>
                @endif

                <hr class="my-3">
                <a href="{{ route('mentor.pengajuan.index') }}" class="btn btn-outline-secondary rounded-pill w-100">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
