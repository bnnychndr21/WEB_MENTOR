@extends('layouts.dashboard')

@section('title', 'Ulasan')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6">
        <div class="card content-card text-center h-100">
            <div class="card-body py-4">
                <div class="text-warning mb-2" style="font-size: 2rem;">
                    <i class="bi bi-star-fill"></i>
                </div>
                <div class="display-5 fw-bold">{{ number_format($rataRating, 1) }}</div>
                <div class="text-muted">Rata-rata Rating</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6">
        <div class="card content-card text-center h-100">
            <div class="card-body py-4">
                <div class="text-primary mb-2" style="font-size: 2rem;">
                    <i class="bi bi-chat-quote-fill"></i>
                </div>
                <div class="display-5 fw-bold">{{ $jumlahUlasan }}</div>
                <div class="text-muted">Total Ulasan</div>
            </div>
        </div>
    </div>
</div>

<div class="card content-card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <span><i class="bi bi-star-fill me-2 text-warning"></i>Semua Ulasan</span>
        <span class="badge bg-primary rounded-pill">{{ $ulasans->total() }} ulasan</span>
    </div>
    <div class="card-body p-0">
        @if ($ulasans->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-star" style="font-size: 3rem; color: #cbd5e1;"></i>
                <p class="mt-2 text-muted">Belum ada ulasan.</p>
            </div>
        @else
            @foreach ($ulasans as $u)
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-start gap-3">
                        @php $mhsFoto = $u->mahasiswa->mahasiswaProfil?->foto; @endphp
                        @if ($mhsFoto)
                            <img src="{{ asset('storage/' . $mhsFoto) }}"
                                 style="width:40px;height:40px;border-radius:50%;object-fit:cover;flex-shrink:0;">
                        @else
                            <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center flex-shrink-0"
                                 style="width: 40px; height: 40px; font-weight: 600;">
                                {{ strtoupper(substr($u->mahasiswa->nama, 0, 1)) }}
                            </div>
                        @endif
                        <div class="flex-grow-1 min-width-0">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="fw-semibold">{{ $u->mahasiswa->nama }}</span>
                                <div class="text-warning" style="font-size: .85rem;">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $u->rating ? '-fill' : '' }}"></i>
                                    @endfor
                                    <span class="ms-1 fw-semibold text-dark">{{ $u->rating }}</span>
                                </div>
                            </div>
                            <div class="text-muted" style="font-size: .8rem;">
                                {{ $u->pengajuan->judul ?? '—' }}
                                &middot;
                                {{ \Carbon\Carbon::parse($u->created_at)->isoFormat('D MMM YYYY') }}
                            </div>
                            @if ($u->komentar)
                                <p class="mb-0 mt-2" style="font-size: .9rem;">{{ $u->komentar }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="d-flex justify-content-center p-3">
                {{ $ulasans->links() }}
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
