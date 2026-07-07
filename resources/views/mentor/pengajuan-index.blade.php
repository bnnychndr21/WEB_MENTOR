@extends('layouts.dashboard')

@section('title', 'Pengajuan Konsultasi')

@section('content')
<div class="card content-card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <span><i class="bi bi-inbox-fill me-2"></i>Semua Pengajuan</span>
        <span class="badge bg-primary rounded-pill">{{ $pengajuans->total() }} pengajuan</span>
    </div>
    <div class="card-body p-0">
        @if ($pengajuans->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-inbox" style="font-size: 3rem; color: #cbd5e1;"></i>
                <p class="mt-2 text-muted">Belum ada pengajuan konsultasi.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="padding-left: 1.5rem;">Mahasiswa</th>
                            <th>Topik</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Status</th>
                            <th class="text-end" style="padding-right: 1.5rem;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengajuans as $p)
                            <tr>
                                <td style="padding-left: 1.5rem;">
                                    <div class="d-flex align-items-center gap-2">
                                        @php $mhsFoto = $p->mahasiswa->mahasiswaProfil?->foto; @endphp
                                        @if ($mhsFoto)
                                            <img src="{{ asset('storage/' . $mhsFoto) }}"
                                                 style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
                                        @else
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center"
                                                 style="width: 36px; height: 36px; font-size: .8rem; font-weight: 600;">
                                                {{ strtoupper(substr($p->mahasiswa->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-semibold" style="font-size: .9rem;">{{ $p->mahasiswa->name }}</div>
                                            <div class="text-muted" style="font-size: .75rem;">{{ $p->mahasiswa->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">
                                        {{ $p->judul }}
                                    </span>
                                </td>
                                <td style="font-size: .9rem;">
                                    @if ($p->tanggal)
                                        {{ \Carbon\Carbon::parse($p->tanggal)->isoFormat('D MMM YYYY') }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td style="font-size: .9rem;">
                                    @if ($p->jam)
                                        {{ \Carbon\Carbon::parse($p->jam)->format('H:i') }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusMap = [
                                            'pending' => ['label' => 'Menunggu', 'class' => 'badge-pending'],
                                            'disetujui' => ['label' => 'Disetujui', 'class' => 'badge-disetujui'],
                                            'ditolak' => ['label' => 'Ditolak', 'class' => 'badge-ditolak'],
                                            'selesai' => ['label' => 'Selesai', 'class' => 'badge-selesai'],
                                            'dibatalkan' => ['label' => 'Dibatalkan', 'class' => 'badge-ditolak'],
                                        ];
                                        $s = $statusMap[$p->status] ?? ['label' => ucfirst($p->status), 'class' => 'badge-pending'];
                                    @endphp
                                    <span class="badge-status {{ $s['class'] }}">{{ $s['label'] }}</span>
                                </td>
                                <td class="text-end" style="padding-right: 1.5rem;">
                                    <div class="d-flex gap-1 justify-content-end">
                                        <a href="{{ route('mentor.pengajuan.show', $p->id) }}"
                                           class="btn btn-sm btn-outline-secondary rounded-pill"
                                           title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if (in_array($p->status, ['disetujui', 'selesai']))
                                            <a href="{{ route('chat.index', $p->id) }}"
                                               class="btn btn-sm btn-primary rounded-pill" title="Chat">
                                                <i class="bi bi-chat-dots-fill"></i>
                                            </a>
                                        @endif
                                        @if ($p->status === 'disetujui')
                                            <form method="POST" action="{{ route('mentor.pengajuan.selesai', $p->id) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success rounded-pill"
                                                        title="Selesaikan" data-confirm="Selesaikan konsultasi ini?">
                                                    <i class="bi bi-check2-all"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @if ($p->status === 'pending')
                                            <form method="POST" action="{{ route('mentor.pengajuan.terima', $p->id) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success rounded-pill"
                                                        title="Terima" data-confirm="Terima pengajuan ini?">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-danger rounded-pill"
                                                    title="Tolak" data-bs-toggle="modal"
                                                    data-bs-target="#tolakModal{{ $p->id }}">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            {{-- Modal Tolak --}}
                            <div class="modal fade" id="tolakModal{{ $p->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="border-radius: 1rem; border: none;">
                                        <form method="POST" action="{{ route('mentor.pengajuan.tolak', $p->id) }}">
                                            @csrf
                                            <div class="modal-header border-0" style="padding: 1.25rem 1.5rem 0;">
                                                <h6 class="modal-title fw-bold">Tolak Pengajuan</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body" style="padding: 1rem 1.5rem;">
                                                <p class="text-muted mb-3" style="font-size: .9rem;">
                                                    Tolak pengajuan dari <strong>{{ $p->mahasiswa->name }}</strong>?
                                                </p>
                                                <label class="form-label fw-semibold" style="font-size: .85rem;">
                                                    Alasan Penolakan (opsional)
                                                </label>
                                                <textarea name="catatan_mentor" rows="3" class="form-control"
                                                          placeholder="Berikan alasan mengapa ditolak..."></textarea>
                                            </div>
                                            <div class="modal-footer border-0" style="padding: 0 1.5rem 1.25rem;">
                                                <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger rounded-pill px-4">Ya, Tolak</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center p-3">
                {{ $pengajuans->links() }}
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .pagination { margin-bottom: 0; }
    .page-link {
        border-radius: .5rem !important;
        margin: 0 2px;
        border: none;
        color: #1e293b;
        font-weight: 500;
    }
    .page-item.active .page-link {
        background: #0ea5e9;
        color: #fff;
    }
    .page-item.disabled .page-link {
        color: #94a3b8;
        background: transparent;
    }
</style>
@endpush
@endsection
