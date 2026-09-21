@extends('layouts.auth')

@section('content')
<div class="auth-card">
    <!-- Brand Header -->
    <div class="text-center mb-4">
        <div class="brand-logo-text">TERA</div>
        <div class="brand-subtitle">Telecommunication Equipment Rental Application</div>
    </div>

    <!-- Card Title -->
    <div class="mb-4">
        <h1 class="auth-title">Konfirmasi Kata Sandi</h1>
        <p class="auth-description mb-0">
            Ini adalah area aman aplikasi. Silakan konfirmasikan kata sandi Anda sebelum melanjutkan.
        </p>
    </div>

    <!-- Error Alert -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 flex-shrink-0"></i>
            <div class="small">{{ $errors->first() }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('password.confirm') }}" novalidate>
        @csrf

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <div class="input-group-password">
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    required 
                    autocomplete="current-password"
                    autofocus
                    placeholder="Masukkan kata sandi Anda"
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

        <button type="submit" class="btn btn-primary-tera w-100 mb-2">
            Konfirmasi
        </button>
    </form>
</div>
@endsection
