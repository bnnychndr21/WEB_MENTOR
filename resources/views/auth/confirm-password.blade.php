<x-guest-layout>
    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center p-3">
        <div class="auth-card bg-white p-4 p-md-5 w-100" style="max-width: 420px;">
            <div class="text-center mb-4">
                <div class="auth-logo mb-3">
                    <i class="bi bi-shield-exclamation"></i>
                </div>
                <h3 class="fw-bold mb-1" style="color: #1e293b;">Konfirmasi Password</h3>
                <p class="text-muted-small mb-0">Konfirmasi password Anda untuk melanjutkan.</p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" novalidate>
                @csrf
                <div class="mb-4">
                    <label class="form-label fw-medium text-dark small">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control password-input @error('password') is-invalid @enderror" name="password" required placeholder="Masukkan password Anda">
                        <button class="btn btn-outline-secondary toggle-password" type="button" style="border:1.5px solid #e2e8f0;border-radius:0 0.75rem 0.75rem 0;border-left:none;background:#fff;">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-check-lg me-2"></i>Konfirmasi
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
