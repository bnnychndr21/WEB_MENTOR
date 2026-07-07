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
                    <i class="bi bi-mortarboard-fill" id="loginIcon"></i>
                </div>
                <h3 class="fw-bold mb-1" style="color: #1e293b;">Selamat Datang</h3>
                <p class="text-muted-small mb-0">Silakan masuk ke akun Anda</p>
            </div>

            <div class="row g-2 mb-4" id="roleToggle">
                <div class="col-6">
                    <div class="role-card active py-2" data-role="mahasiswa">
                        <input type="radio" class="d-none" checked>
                        <i class="bi bi-mortarboard-fill"></i>
                        <div class="role-label small">Mahasiswa</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="role-card py-2" data-role="mentor">
                        <input type="radio" class="d-none">
                        <i class="bi bi-person-badge-fill"></i>
                        <div class="role-label small">Mentor</div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-medium text-dark small">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                    </div>
                    @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium text-dark small">Kata Sandi</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control password-input @error('kata_sandi') is-invalid @enderror" name="kata_sandi" required placeholder="Masukkan kata sandi">
                        <button class="btn btn-outline-secondary toggle-password" type="button" style="border:1.5px solid #e2e8f0;border-radius:0 0.75rem 0.75rem 0;border-left:none;background:#fff;">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('kata_sandi') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                        <label class="form-check-label text-muted-small small" for="remember_me">Ingat saya</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-decoration-none small fw-medium" style="color:var(--primary);">Lupa kata sandi?</a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                </button>
            </form>

            <div class="divider mb-3"><span>atau</span></div>

            <p class="text-center text-muted-small mb-0 small" id="daftarText">
                Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none fw-medium" style="color:var(--primary);">Daftar</a>
            </p>
        </div>
    </div>

    <script>
    document.querySelectorAll('#roleToggle .role-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('#roleToggle .role-card').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            const role = this.dataset.role;
            const icon = document.getElementById('loginIcon');
            icon.className = role === 'mahasiswa' ? 'bi bi-mortarboard-fill' : 'bi bi-person-badge-fill';
        });
    });
    </script>
</x-guest-layout>
