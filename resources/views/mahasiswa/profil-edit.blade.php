@extends('layouts.dashboard')

@section('title', 'Edit Profil')

@section('content')
<div class="row g-4">
    <div class="col-12 col-lg-8 mx-auto">
        <div class="card content-card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-pencil-square"></i>
                {{ $profil ? 'Edit Profil' : 'Lengkapi Profil' }}
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('mahasiswa.profil.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <div id="previewContainer" style="width: 120px; height: 120px; margin: 0 auto;">
                                @if ($profil && $profil->foto)
                                    <img id="preview" src="{{ asset('storage/' . $profil->foto) }}"
                                         class="rounded-circle border border-3 border-primary"
                                         style="width: 120px; height: 120px; object-fit: cover;">
                                @else
                                    <div id="previewPlaceholder"
                                         class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto border border-3 border-primary"
                                         style="width: 120px; height: 120px; font-size: 2.5rem; color: #fff;">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <img id="preview" src="#" alt="Preview"
                                         class="rounded-circle border border-3 border-primary d-none"
                                         style="width: 120px; height: 120px; object-fit: cover;">
                                @endif
                            </div>
                            <label for="foto" class="position-absolute bottom-0 end-0 btn btn-sm btn-primary rounded-circle p-1 shadow"
                                   style="cursor: pointer;">
                                <i class="bi bi-camera-fill"></i>
                            </label>
                        </div>
                        <input type="file" id="foto" name="foto" class="d-none" accept="image/*" onchange="previewImage(event)">
                        <p class="text-muted mt-2" style="font-size: .8rem;">Format: jpeg/png, maks 2MB</p>
                        @error('foto')
                            <div class="text-danger" style="font-size: .85rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">Jurusan <span class="text-danger">*</span></label>
                            <input type="text" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror"
                                   value="{{ old('jurusan', $profil->jurusan ?? '') }}" required>
                            @error('jurusan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">Universitas <span class="text-danger">*</span></label>
                            <input type="text" name="universitas" class="form-control @error('universitas') is-invalid @enderror"
                                   value="{{ old('universitas', $profil->universitas ?? '') }}" required>
                            @error('universitas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">Semester <span class="text-danger">*</span></label>
                            <select name="semester" class="form-select @error('semester') is-invalid @enderror" required>
                                @for ($i = 1; $i <= 14; $i++)
                                    <option value="{{ $i }}" {{ old('semester', $profil->semester ?? '') == $i ? 'selected' : '' }}>
                                        Semester {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            @error('semester')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">No. HP</label>
                            <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                                   value="{{ old('no_hp', $profil->no_hp ?? '') }}">
                            @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Biodata</label>
                            <textarea name="biodata" rows="3" class="form-control @error('biodata') is-invalid @enderror">{{ old('biodata', $profil->biodata ?? '') }}</textarea>
                            @error('biodata')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('mahasiswa.profil') }}" class="btn btn-outline-secondary rounded-pill">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-check-lg me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(ev) {
        const img = document.getElementById('preview');
        const placeholder = document.getElementById('previewPlaceholder');
        if (placeholder) placeholder.classList.add('d-none');
        img.classList.remove('d-none');
        img.src = ev.target.result;
    }
    reader.readAsDataURL(file);
}
</script>
@endpush
@endsection
