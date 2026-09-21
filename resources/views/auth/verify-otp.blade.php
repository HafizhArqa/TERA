@extends('layouts.auth')

@section('content')
 <div class="text-center mb-4">
        <div class="brand-logo-text">TERA</div>
        <div class="brand-subtitle">Telecommunication Equipment Rental Application</div>
    </div>
<div class="auth-card">
    <!-- Brand Header -->
   

    <!-- Card Title -->
    <div class="mb-4 text-center">
        <div style="width:64px; height:64px; background: #081e53ff; 
        border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
        <!-- <div style="width:64px;height:64px;background:linear-gradient(135deg,#1a3c5e,#2d6a9f);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;"> -->
            <i class="bi bi-shield-lock-fill" style="font-size:28px;color:#fff;"></i>
        </div>
        <h1 class="auth-title">Verifikasi OTP</h1>
        <p class="auth-description mb-0">
            Masukkan kode 6 digit yang telah dikirim ke<br>
            <strong>{{ $email }}</strong>
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

    <!-- OTP Form -->
    <form method="POST" action="{{ route('otp.verify') }}" novalidate id="otp-form">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <!-- OTP Input Boxes -->
        <div class="mb-4">
            <label class="form-label text-center d-block mb-3">Kode OTP</label>
            <div class="d-flex justify-content-center gap-2" id="otp-inputs">
                @for ($i = 1; $i <= 6; $i++)
                    <input
                        type="text"
                        maxlength="1"
                        class="otp-digit-input form-control text-center fw-bold"
                        id="otp-digit-{{ $i }}"
                        inputmode="numeric"
                        pattern="[0-9]"
                        autocomplete="off"
                        style="width:48px;height:56px;font-size:24px;border-radius:10px;border:2px solid #dee2e6;transition:border-color .2s,box-shadow .2s;padding:0;box-sizing:border-box;"
                    >
                @endfor
            </div>
            <!-- Hidden input yang akan dikumpulkan -->
            <input type="hidden" name="otp" id="otp-hidden">
        </div>

        <!-- Timer -->
        <div class="text-center mb-4">
            <small class="text-muted">
                Kode berlaku selama <span id="countdown" class="fw-bold text-warning">10:00</span>
            </small>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary-tera w-100 mb-3" id="verify-btn">
            <i class="bi bi-shield-check me-2"></i>Verifikasi OTP
        </button>
    </form>

    <!-- Resend OTP Form (Terpisah dari form verifikasi) -->
    <div class="text-center mb-3">
        <small class="text-muted">Tidak menerima kode? </small>
        <form method="POST" action="{{ route('otp.resend') }}" style="display:inline;" id="resend-otp-form">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <button type="submit" class="btn btn-link p-0 auth-link small fw-semibold" style="font-size:inherit; text-decoration:none;" id="resend-btn">
                Kirim ulang OTP
            </button>
        </form>
    </div>

    <!-- Back to Login -->
    <div class="text-center">
        <a href="{{ route('login') }}" class="auth-link d-inline-flex align-items-center small">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Login
        </a>
    </div>
</div>

<style>
.otp-digit-input:focus {
    border-color: #2d6a9f !important;
    box-shadow: 0 0 0 3px rgba(45, 106, 159, 0.15) !important;
    outline: none;
}
.otp-digit-input.filled {
    border-color: #1a3c5e !important;
    background-color: #f0f7ff;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('.otp-digit-input');
    const hiddenInput = document.getElementById('otp-hidden');
    const form = document.getElementById('otp-form');

    // Auto-focus first input
    inputs[0].focus();

    // Handle input per digit
    inputs.forEach((input, index) => {
        input.addEventListener('input', function (e) {
            // Hanya angka
            this.value = this.value.replace(/[^0-9]/g, '');

            if (this.value) {
                this.classList.add('filled');
                // Pindah ke input berikutnya
                if (index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            } else {
                this.classList.remove('filled');
            }
            updateHidden();
        });

        // Handle backspace
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Backspace' && !this.value && index > 0) {
                inputs[index - 1].focus();
                inputs[index - 1].value = '';
                inputs[index - 1].classList.remove('filled');
                updateHidden();
            }
        });

        // Handle paste
        input.addEventListener('paste', function (e) {
            e.preventDefault();
            const pasted = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, 6);
            pasted.split('').forEach((char, i) => {
                if (inputs[i]) {
                    inputs[i].value = char;
                    inputs[i].classList.add('filled');
                }
            });
            if (inputs[pasted.length - 1]) inputs[pasted.length - 1].focus();
            updateHidden();
        });
    });

    function updateHidden() {
        hiddenInput.value = Array.from(inputs).map(i => i.value).join('');
    }

    // Pre-fill jika ada old value (error case)
    @if(old('otp'))
        const oldOtp = '{{ old('otp') }}';
        oldOtp.split('').forEach((char, i) => {
            if (inputs[i]) {
                inputs[i].value = char;
                inputs[i].classList.add('filled');
            }
        });
        updateHidden();
    @endif

    // Countdown timer 10 menit
    let timeLeft = 10 * 60;
    const countdownEl = document.getElementById('countdown');
    const verifyBtn = document.getElementById('verify-btn');

    const timer = setInterval(() => {
        timeLeft--;
        const mins = Math.floor(timeLeft / 60).toString().padStart(2, '0');
        const secs = (timeLeft % 60).toString().padStart(2, '0');
        countdownEl.textContent = `${mins}:${secs}`;

        if (timeLeft <= 60) {
            countdownEl.classList.remove('text-warning');
            countdownEl.classList.add('text-danger');
        }

        if (timeLeft <= 0) {
            clearInterval(timer);
            countdownEl.textContent = 'Kadaluwarsa';
            verifyBtn.disabled = true;
            verifyBtn.textContent = 'Kode OTP Kadaluwarsa';
        }
    }, 1000);
});
</script>
@endsection
