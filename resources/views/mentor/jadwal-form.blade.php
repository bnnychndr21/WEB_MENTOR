@extends('layouts.dashboard')

@section('title', isset($jadwal) ? 'Edit Jadwal' : 'Tambah Jadwal')

@section('content')
<div class="row g-4">
    <div class="col-12 col-lg-6 mx-auto">
        <div class="card content-card">
            <div class="card-header">
                <i class="bi {{ isset($jadwal) ? 'bi-pencil-square' : 'bi-plus-lg' }} me-2"></i>
                {{ isset($jadwal) ? 'Edit Jadwal' : 'Tambah Jadwal' }}
            </div>
            <div class="card-body">
                <form method="POST"
                      action="{{ isset($jadwal) ? route('mentor.jadwal.update', $jadwal->id) : route('mentor.jadwal.store') }}">
                    @csrf
                    @if (isset($jadwal))
                        @method('PUT')
                    @endif

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal"
                                   class="form-control @error('tanggal') is-invalid @enderror"
                                   value="{{ old('tanggal', isset($jadwal) ? $jadwal->tanggal->format('Y-m-d') : '') }}"
                                   min="{{ date('Y-m-d') }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">Jam Mulai <span class="text-danger">*</span></label>
                            <input type="time" name="jam_mulai"
                                   class="form-control @error('jam_mulai') is-invalid @enderror"
                                   value="{{ old('jam_mulai', isset($jadwal) ? \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') : '') }}"
                                   required>
                            @error('jam_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">Jam Selesai <span class="text-danger">*</span></label>
                            <input type="time" name="jam_selesai"
                                   class="form-control @error('jam_selesai') is-invalid @enderror"
                                   value="{{ old('jam_selesai', isset($jadwal) ? \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') : '') }}"
                                   required>
                            @error('jam_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('mentor.jadwal.index') }}" class="btn btn-outline-secondary rounded-pill">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-check-lg me-1"></i>
                            {{ isset($jadwal) ? 'Simpan Perubahan' : 'Tambah Jadwal' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
