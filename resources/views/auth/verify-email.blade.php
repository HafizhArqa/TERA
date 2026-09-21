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
        <h1 class="auth-title">Verifikasi Email</h1>
        <p class="auth-description mb-0">
            Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan ke email Anda.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 flex-shrink-0"></i>
            <div class="small">Tautan verifikasi baru telah dikirimkan ke alamat email yang Anda berikan saat pendaftaran.</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-grid gap-2">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary-tera w-100 mb-2">
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary w-100">
                Log Out
            </button>
        </form>
    </div>
</div>
@endsection
