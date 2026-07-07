<x-guest-layout>
    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center p-3">
        <div class="auth-card bg-white p-4 p-md-5 w-100" style="max-width: 540px;">
            <div class="text-center mb-4">
                <div class="auth-logo mb-3">
                    <i class="bi bi-person-plus-fill"></i>
                </div>
                <h3 class="fw-bold mb-1" style="color: #1e293b;">Buat Akun Baru</h3>
                <p class="text-muted-small mb-0">Daftar sebagai Mahasiswa atau Mentor</p>
            </div>

            <form method="POST" action="{{ route('register') }}" novalidate>
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-medium text-dark small">Daftar Sebagai</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="role-card py-2 {{ old('role') === 'mahasiswa' ? 'active' : '' }}">
                                <input type="radio" name="role" value="mahasiswa" class="d-none" {{ old('role') === 'mahasiswa' ? 'checked' : '' }} required>
                                <i class="bi bi-mortarboard-fill"></i>
                                <div class="role-label small">Mahasiswa</div>
                                <div class="role-desc">Cari Mentor</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="role-card py-2 {{ old('role') === 'mentor' ? 'active' : '' }}">
                                <input type="radio" name="role" value="mentor" class="d-none" {{ old('role') === 'mentor' ? 'checked' : '' }}>
                                <i class="bi bi-person-badge-fill"></i>
                                <div class="role-label small">Mentor</div>
                                <div class="role-desc">Alumni / Profesional</div>
                            </div>
                        </div>
                    </div>
                    @error('role') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium text-dark small">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap">
                    </div>
                    @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium text-dark small">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="nama@email.com">
                    </div>
                    @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-medium text-dark small">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control password-input @error('password') is-invalid @enderror" name="password" required placeholder="Min. 8 karakter">
                            <button class="btn btn-outline-secondary toggle-password" type="button" style="border:1.5px solid #e2e8f0;border-radius:0 0.75rem 0.75rem 0;border-left:none;background:#fff;">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium text-dark small">Konfirmasi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control password-input @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required placeholder="Ulangi password">
                            <button class="btn btn-outline-secondary toggle-password" type="button" style="border:1.5px solid #e2e8f0;border-radius:0 0.75rem 0.75rem 0;border-left:none;background:#fff;">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password_confirmation') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">
                    <i class="bi bi-person-check me-2"></i>Daftar
                </button>
            </form>

            <div class="divider mb-3"><span>atau</span></div>

            <p class="text-center text-muted-small mb-0 small">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none fw-medium" style="color:var(--primary);">Masuk</a>
            </p>
        </div>
    </div>
</x-guest-layout>
