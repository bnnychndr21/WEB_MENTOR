@extends('layouts.dashboard')

@section('title', 'Chat - ' . $pengajuan->mahasiswa->name)

@section('content')
<div class="row g-0" style="height: calc(100vh - 100px);">
    <div class="col-12 col-lg-8 mx-auto d-flex flex-col" style="height: 100%;">
        <div class="d-flex flex-column flex-grow-1 bg-white rounded-4 shadow-sm overflow-hidden" style="border: 1px solid #e5e7eb;">

            {{-- Header --}}
            <div class="d-flex align-items-center gap-3 px-3 py-3" style="background: #f0f2f5; border-bottom: 1px solid #e5e7eb;">
                <a href="{{ auth()->user()->role === 'mahasiswa' ? route('mahasiswa.pengajuan.index') : route('mentor.pengajuan.show', $pengajuan->id) }}"
                   class="btn btn-sm rounded-circle p-1" style="background: transparent; color: #54656f;">
                    <i class="bi bi-arrow-left" style="font-size: 1.3rem;"></i>
                </a>
                @php
                    $partnerFoto = auth()->user()->role === 'mahasiswa'
                        ? $pengajuan->mentorProfil?->foto
                        : $pengajuan->mahasiswa?->mahasiswaProfil?->foto;
                @endphp
                @if ($partnerFoto)
                    <img src="{{ asset('storage/' . $partnerFoto) }}"
                         style="width:40px;height:40px;border-radius:50%;object-fit:cover;flex-shrink:0;">
                @else
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                         style="width: 40px; height: 40px; background: #dfe5ea; color: #54656f; font-weight: 600; font-size: .9rem; flex-shrink: 0;">
                        {{ strtoupper(substr($partnerName, 0, 1)) }}
                    </div>
                @endif
                <div class="flex-grow-1 min-w-0">
                    <div class="fw-semibold" style="font-size: .95rem; color: #111b21;">{{ $partnerName }}</div>
                    <div style="font-size: .75rem; color: #667781;">
                        {{ auth()->user()->role === 'mahasiswa' ? 'Mentor' : 'Mahasiswa' }}
                        &middot; {{ $pengajuan->judul }}
                    </div>
                </div>
            </div>

            {{-- Messages --}}
            <div id="chatMessages" class="flex-grow-1 overflow-auto px-3 py-3"
                 style="background: #efeae2 url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23d4cfc4\' fill-opacity=\'0.15\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                @forelse ($messages as $msg)
                    <div class="d-flex mb-2 {{ $msg->sender_id === auth()->id() ? 'justify-content-end' : '' }}">
                        <div class="chat-bubble {{ $msg->sender_id === auth()->id() ? 'chat-own' : 'chat-other' }}">
                            <div class="chat-text">{{ $msg->message }}</div>
                            <div class="chat-time">{{ $msg->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5" id="emptyChat">
                        <div style="font-size: 3rem; color: #a0a89f;">
                            <i class="bi bi-chat-dots"></i>
                        </div>
                        <p class="mt-2" style="color: #8696a0; font-size: .9rem;">Belum ada pesan. Mulai percakapan!</p>
                    </div>
                @endforelse

                {{-- Rating --}}
                @if ($pengajuan->status === 'selesai' && auth()->user()->role === 'mahasiswa' && !in_array($pengajuan->id, $ratedPengajuanIds))
                    <div class="text-center py-3 mt-2" style="background: rgba(255,255,255,0.85); border-radius: 10px;">
                        <div class="text-warning mb-1" style="font-size: 1.5rem;"><i class="bi bi-star-fill"></i></div>
                        <h6 class="fw-bold" style="color: #111b21; font-size: .85rem;">Konsultasi Selesai</h6>
                        <p class="mb-2" style="color: #667781; font-size: .8rem;">Berikan rating untuk mentor Anda</p>
                        <button type="button" class="btn btn-sm rounded-pill px-3" style="background: #00a884; color: #fff; border: none;"
                                data-bs-toggle="modal" data-bs-target="#ulasanChatModal">
                            <i class="bi bi-star-fill me-1"></i> Beri Rating
                        </button>
                    </div>
                    {{-- Modal --}}
                    <div class="modal fade" id="ulasanChatModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content" style="border-radius: 1rem; border: none;">
                                <form method="POST" action="{{ route('mahasiswa.ulasan.store', $pengajuan->id) }}">
                                    @csrf
                                    <div class="modal-header border-0" style="padding: 1.25rem 1.5rem 0;">
                                        <h6 class="modal-title fw-bold"><i class="bi bi-star-fill text-warning me-1"></i>Beri Rating</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body" style="padding: 1rem 1.5rem;">
                                        <p class="text-muted mb-3" style="font-size: .9rem;">
                                            Penilaian untuk <strong>{{ $partnerName }}</strong>
                                        </p>
                                        <label class="form-label fw-semibold" style="font-size: .85rem;">Rating <span class="text-danger">*</span></label>
                                        <div class="star-rating mb-3 text-center">
                                            <div class="stars d-inline-flex flex-row-reverse gap-1">
                                                @for ($i = 5; $i >= 1; $i--)
                                                    <input type="radio" name="rating" value="{{ $i }}" id="starChat{{ $i }}" required>
                                                    <label for="starChat{{ $i }}" title="{{ $i }} bintang">
                                                        <i class="bi bi-star fs-3"></i>
                                                    </label>
                                                @endfor
                                            </div>
                                        </div>
                                        <label class="form-label fw-semibold" style="font-size: .85rem;">Komentar (opsional)</label>
                                        <textarea name="komentar" rows="3" class="form-control" placeholder="Tulis ulasan..." maxlength="1000"></textarea>
                                    </div>
                                    <div class="modal-footer border-0" style="padding: 0 1.5rem 1.25rem;">
                                        <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning rounded-pill px-4">Kirim</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @elseif ($pengajuan->status === 'selesai' && auth()->user()->role === 'mahasiswa' && in_array($pengajuan->id, $ratedPengajuanIds))
                    <div class="text-center py-3 mt-2" style="background: rgba(255,255,255,0.85); border-radius: 10px;">
                        <div class="text-warning mb-1" style="font-size: 1.5rem;"><i class="bi bi-star-fill"></i></div>
                        <p class="mb-0" style="color: #667781; font-size: .85rem;">Terima kasih! Anda sudah memberikan rating.</p>
                    </div>
                @endif
            </div>

            {{-- Input --}}
            <div class="p-3" style="background: #f0f2f5; border-top: 1px solid #e5e7eb;">
                <form id="chatForm" class="d-flex gap-2">
                    @csrf
                    <input type="text" id="messageInput" class="form-control rounded-pill border-0"
                           placeholder="Ketik pesan..." maxlength="2000" required autocomplete="off"
                           style="background: #fff; padding: .6rem 1rem; font-size: .9rem; box-shadow: none;">
                    <button type="submit" class="btn rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 42px; height: 42px; background: #00a884; color: #fff; border: none; padding: 0;">
                        <i class="bi bi-send-fill" style="font-size: 1rem;"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    #chatMessages {
        scroll-behavior: smooth;
    }
    .chat-bubble {
        max-width: 75%;
        padding: .5rem .75rem;
        word-wrap: break-word;
        position: relative;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.06);
    }
    .chat-own {
        background: #dcf8c6;
        color: #111b21;
        border-radius: 8px 0 8px 8px;
    }
    .chat-own::after {
        content: '';
        position: absolute;
        top: 8px;
        right: -6px;
        border: 6px solid transparent;
        border-left-color: #dcf8c6;
        border-right: 0;
        border-bottom: 0;
    }
    .chat-other {
        background: #fff;
        color: #111b21;
        border-radius: 0 8px 8px 8px;
        border: 1px solid #e5e7eb;
    }
    .chat-other::after {
        content: '';
        position: absolute;
        top: 8px;
        left: -7px;
        border: 6px solid transparent;
        border-right-color: #fff;
        border-left: 0;
        border-bottom: 0;
    }
    .chat-text {
        font-size: .9rem;
        line-height: 1.4;
        white-space: pre-wrap;
    }
    .chat-time {
        font-size: .65rem;
        margin-top: 2px;
        text-align: right;
        color: rgba(17, 27, 33, 0.45);
    }
    .chat-own .chat-time {
        color: rgba(17, 27, 33, 0.55);
    }
    .star-rating .stars input { display: none; }
    .star-rating .stars label { cursor: pointer; color: #cbd5e1; transition: color .15s; }
    .star-rating .stars label:hover,
    .star-rating .stars label:hover ~ label,
    .star-rating .stars input:checked ~ label { color: #f59e0b; }
</style>
@endpush

@push('scripts')
<script>
    const pengajuanId = {{ $pengajuan->id }};
    const chatUrl = "{{ route('chat.fetch', $pengajuan->id) }}";
    const sendUrl = "{{ route('chat.send', $pengajuan->id) }}";
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    let lastMessageId = {{ $messages->last()?->id ?? 0 }};
    let isPolling = true;

    const chatMessages = document.getElementById('chatMessages');
    const emptyChat = document.getElementById('emptyChat');
    const form = document.getElementById('chatForm');
    const input = document.getElementById('messageInput');

    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function addMessage(msg, isOwn) {
        if (emptyChat) emptyChat.remove();

        const div = document.createElement('div');
        div.className = 'd-flex mb-3 ' + (isOwn ? 'justify-content-end' : '');
        div.innerHTML = `
            <div class="chat-bubble ${isOwn ? 'chat-own' : 'chat-other'}">
                <div class="chat-text">${msg.message}</div>
                <div class="chat-time">${msg.time}</div>
            </div>
        `;
        chatMessages.appendChild(div);
        scrollToBottom();
    }

    async function fetchMessages() {
        if (!isPolling) return;
        try {
            const res = await fetch(`${chatUrl}?last_id=${lastMessageId}`, {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();
            const userId = {{ auth()->id() }};
            data.messages.forEach(msg => {
                addMessage(msg, msg.sender_id === userId);
                lastMessageId = msg.id;
            });
        } catch (e) {
            // silent
        }
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        const message = input.value.trim();
        if (!message) return;

        input.disabled = true;
        try {
            const res = await fetch(sendUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ message })
            });
            const msg = await res.json();
            addMessage(msg, true);
            lastMessageId = msg.id;
            input.value = '';
            input.focus();
            fetchMessages();
        } catch (e) {
            alert('Gagal mengirim pesan.');
        }
        input.disabled = false;
    });

    scrollToBottom();
    setInterval(fetchMessages, 3000);
</script>
@endpush
