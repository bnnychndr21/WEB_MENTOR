<x-guest-layout>
    @if (session('status'))
        <div class="container-fluid pt-3">
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center rounded-4 mx-3" role="alert" style="max-width: 460px; margin: 0 auto;">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center p-3">
        <div class="auth-card bg-white p-4 p-md-5 w-100" style="max-width: 460px;">
            <div class="text-center mb-4">
                <div class="auth-logo mb-3">
                    <i class="bi bi-key-fill"></i>
                </div>
                <h3 class="fw-bold mb-1" style="color: #1e293b;">Lupa Password</h3>
                <p class="text-muted-small mb-0">Masukkan email untuk menerima tautan reset.</p>
            </div>

            <form method="POST" action="{{ route('password.email') }}" novalidate>
                @csrf
                <div class="mb-4">
                    <label class="form-label fw-medium text-dark small">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                    </div>
                    @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3">
                    <i class="bi bi-send me-2"></i>Kirim Tautan Reset
                </button>
            </form>

            <div class="divider mb-3"><span>atau</span></div>
            <p class="text-center text-muted-small mb-0 small">
                <a href="{{ route('login') }}" class="text-decoration-none fw-medium" style="color:var(--primary);">
                    <i class="bi bi-arrow-left me-1"></i>Kembali ke Login
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
