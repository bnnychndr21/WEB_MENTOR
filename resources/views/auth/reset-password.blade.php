<x-guest-layout>
    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center p-3">
        <div class="auth-card bg-white p-4 p-md-5 w-100" style="max-width: 460px;">
            <div class="text-center mb-4">
                <div class="auth-logo mb-3">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <h3 class="fw-bold mb-1" style="color: #1e293b;">Reset Password</h3>
                <p class="text-muted-small mb-0">Buat password baru untuk akun Anda</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" novalidate>
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="mb-3">
                    <label class="form-label fw-medium text-dark small">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $request->email) }}" required autofocus placeholder="nama@email.com">
                    </div>
                    @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium text-dark small">Kata Sandi Baru</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control password-input @error('kata_sandi') is-invalid @enderror" name="kata_sandi" required placeholder="Minimal 8 karakter">
                        <button class="btn btn-outline-secondary toggle-password" type="button" style="border:1.5px solid #e2e8f0;border-radius:0 0.75rem 0.75rem 0;border-left:none;background:#fff;">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('kata_sandi') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-medium text-dark small">Konfirmasi Kata Sandi</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" class="form-control password-input @error('kata_sandi_confirmation') is-invalid @enderror" name="kata_sandi_confirmation" required placeholder="Ulangi kata sandi">
                        <button class="btn btn-outline-secondary toggle-password" type="button" style="border:1.5px solid #e2e8f0;border-radius:0 0.75rem 0.75rem 0;border-left:none;background:#fff;">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('kata_sandi_confirmation') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">
                    <i class="bi bi-check-circle me-2"></i>Reset Password
                </button>
            </form>

            <p class="text-center text-muted-small mb-0 small">
                <a href="{{ route('login') }}" class="text-decoration-none fw-medium" style="color:var(--primary);">
                    <i class="bi bi-arrow-left me-1"></i>Kembali ke Login
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
