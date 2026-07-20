@extends('layouts.app')

@section('title', 'Registrasi')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 85vh;">
    <div class="col-12 col-sm-8 col-md-6 col-lg-4">
        <div class="text-center mb-4">
            <i class="bi bi-wrench-adjustable-circle text-dark" style="font-size: 3rem;"></i>
            <h1 class="h4 fw-bold mt-2">Registrasi Mekanik</h1>
            <p class="text-muted">Buat akun baru</p>
        </div>
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">No. HP <span class="text-muted">(opsional)</span></label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                               id="phone" name="phone" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                               name="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">
                        <i class="bi bi-person-plus me-1"></i>Daftar
                    </button>
                </form>
            </div>
        </div>
        <p class="text-center text-muted mt-3">
            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
        </p>
    </div>
</div>
@endsection
