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
        <h1 class="auth-title">Forgot Password?</h1>
        <p class="auth-description mb-0">
            No problem. Enter your account email address below and we will send you a password reset link.
        </p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 flex-shrink-0"></i>
            <div class="small">{{ session('status') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Error Alert -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 flex-shrink-0"></i>
            <div class="small">{{ $errors->first() }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Forgot Password Form -->
    <form method="POST" action="{{ route('password.email') }}" novalidate>
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="form-label">Email Address</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                class="form-control @error('email') is-invalid @enderror" 
                value="{{ old('email') }}" 
                placeholder="name@company.com" 
                required 
                autofocus
            >
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary-tera w-100 mb-3">
            Send Password Reset Link
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
