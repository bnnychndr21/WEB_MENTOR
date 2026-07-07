<x-guest-layout>
    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center p-3">
        <div class="auth-card bg-white p-4 p-md-5 w-100" style="max-width: 520px;">
            <div class="text-center mb-4">
                <div class="auth-logo mb-3">
                    <i class="bi bi-envelope-check-fill"></i>
                </div>
                <h3 class="fw-bold mb-1" style="color: #1e293b;">Verifikasi Email</h3>
                <p class="text-muted-small mb-0">Terima kasih telah mendaftar! Silakan verifikasi email Anda.</p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success d-flex align-items-center rounded-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Tautan verifikasi baru telah dikirim ke email Anda.
                </div>
            @endif

            <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center mt-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send me-2"></i>Kirim Ulang Email
                    </button>
                </form>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="bi bi-box-arrow-right me-2"></i>Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
