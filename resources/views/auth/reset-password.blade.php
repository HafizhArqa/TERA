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
        <h1 class="auth-title">Reset Password</h1>
        <p class="auth-description mb-0">
            Please enter your new password to secure your account.
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

    <!-- Reset Password Form -->
    <form method="POST" action="{{ route('password.store') }}" novalidate>
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                class="form-control @error('email') is-invalid @enderror" 
                value="{{ old('email', $request->email) }}" 
                required 
                readonly
            >
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- New Password -->
        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
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
            <label for="password_confirmation" class="form-label">Confirm New Password</label>
            <div class="input-group-password">
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="form-control @error('password_confirmation') is-invalid @enderror" 
                    placeholder="Ulangi kata sandi baru" 
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
            Reset Password
        </button>

        <!-- Back to Login Link -->
        <div class="text-center">
            <a href="{{ route('login') }}" class="auth-link d-inline-flex align-items-center">
                <i class="bi bi-arrow-left me-1"></i> Back to Log In
            </a>
        </div>
    </form>
</div>
@endsection
