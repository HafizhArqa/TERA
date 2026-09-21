@extends('layouts.auth')

@section('content')

<style>

</style>

 <div class="text-center mb-4">
        <div class="brand-logo-text">TERA</div>
        <div class="brand-subtitle">Telecommunication Equipment Rental Application</div>
    </div>
<div class="auth-card">
    <!-- Brand Header -->
   

    <!-- Card Title -->
    <div class="mb-4">
        <h1 class="auth-title">Welcome Back</h1>
        <p class="auth-description mb-0">Please enter your credentials to manage your inventory</p>
    </div>

    <!-- Session Status (e.g. Password reset link sent or logout message) -->
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 flex-shrink-0"></i>
            <div class="small">{{ session('status') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- General Error Alert -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 flex-shrink-0"></i>
            <div class="small">
                @if ($errors->has('login'))
                    {{ $errors->first('login') }}
                @else
                    {{ $errors->first() }}
                @endif
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        <!-- Email Address / Username -->
        <div class="mb-3">
            <label for="login" class="form-label">Email Address</label>
            <div class="input-group">
                <input 
                    type="text" 
                    id="login" 
                    name="login" 
                    class="form-control @error('login') is-invalid @enderror" 
                    value="{{ old('login') }}" 
                    placeholder="name@company.com or username" 
                    required 
                    autofocus 
                    autocomplete="username"
                >
            </div>
            @error('login')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="password" class="form-label mb-0">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="auth-link">
                        Forgot Password?
                    </a>
                @endif
            </div>
            <div class="input-group-password">
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" 
                    required 
                    autocomplete="current-password"
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

        <!-- Remember Device Checkbox -->
        <!-- <div class="mb-4 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
                Remember this device
            </label>
        </div> -->
<div class="text-center mt-3">
    <span class="text-muted">Don't have an account?</span>
    <a href="{{ route('register') }}" class="auth-link">
        Register
    </a>
    <br>
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary-tera w-100 mb-3">
            Log In
        </button>

        <!-- Demo Account Quick Fill / Helper for evaluators -->
        <!-- <div class="card border-0 bg-light rounded-3 p-2 text-center" style="font-size: 0.78rem;">
            <div class="text-muted mb-1 fw-semibold">Akun Uji Coba (Berdasarkan SRS & SDD):</div>
            <div class="d-flex justify-content-center gap-2">
                <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size: 0.75rem;" onclick="fillLogin('admin@tera.com', 'admin123')">
                    Admin
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2" style="font-size: 0.75rem;" onclick="fillLogin('pelanggan@tera.com', 'pelanggan123')">
                    Pelanggan
                </button>
            </div>
        </div> -->
    </form>
</div>
@endsection

@push('scripts')
<script>
    function fillLogin(email, password) {
        document.getElementById('login').value = email;
        document.getElementById('password').value = password;
    }
</script>
@endpush
