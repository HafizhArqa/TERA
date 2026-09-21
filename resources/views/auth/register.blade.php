@extends('layouts.auth')

@section('content')
 <div class="text-center mb-4">
        <div class="brand-logo-text">TERA</div>
        <div class="brand-subtitle">Telecommunication Equipment Rental Application</div>
    </div>

<div class="auth-card">
    <!-- Brand Header -->
   
    <!-- Card Title -->
    <div class="mb-4">
        <h1 class="auth-title">Daftar Akun Baru</h1>
        <p class="auth-description mb-0">Registrasi akun pelanggan tetap sistem TERA</p>
    </div>

    <!-- General Error Alert -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 flex-shrink-0"></i>
            <div class="small">{{ $errors->first() }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Registration Form -->
    <form method="POST" action="{{ route('register') }}" novalidate>
        @csrf

        <!-- Nama Lengkap -->
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Lengkap</label>
            <input 
                type="text" 
                id="nama" 
                name="nama" 
                class="form-control @error('nama') is-invalid @enderror" 
                value="{{ old('nama') }}" 
                placeholder="cth. Alexandre Dumas" 
                required 
                autofocus
            >
            @error('nama')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Username -->
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input 
                type="text" 
                id="username" 
                name="username" 
                class="form-control @error('username') is-invalid @enderror" 
                value="{{ old('username') }}" 
                placeholder="cth. alexandre" 
                required
            >
            @error('username')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                class="form-control @error('email') is-invalid @enderror" 
                value="{{ old('email') }}" 
                placeholder="name@company.com" 
                required
            >
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group-password">
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    placeholder="Minimal 8 karakter" 
                    required 
                    autocomplete="new-password"
                    style="padding-right: 40px;"
                >
                <button type="button" class="password-toggle-btn" onclick="togglePassword('password', 'password-toggle-icon')" tabindex="-1" aria-label="Toggle password visibility">
                    <i id="password-toggle-icon" class="bi bi-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <div class="input-group-password">
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="form-control @error('password_confirmation') is-invalid @enderror" 
                    placeholder="Ulangi password" 
                    required 
                    autocomplete="new-password"
                    style="padding-right: 40px;"
                >
                <button type="button" class="password-toggle-btn" onclick="togglePassword('password_confirmation', 'password-confirm-toggle-icon')" tabindex="-1" aria-label="Toggle password confirmation visibility">
                    <i id="password-confirm-toggle-icon" class="bi bi-eye"></i>
                </button>
            </div>
            @error('password_confirmation')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary-tera w-100 mb-3">
            Daftar Sekarang
        </button>

        <!-- Back to Login Link -->
        <div class="text-center">
            <span class="text-muted small">Sudah memiliki akun?</span>
            <a href="{{ route('login') }}" class="auth-link ms-1">
                Log In
            </a>
        </div>
    </form>
</div>
@endsection
