<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     * Generate OTP and send via email.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Cek apakah email terdaftar di sistem
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Alamat email tidak ditemukan dalam sistem.']);
        }

        // Generate OTP 6 digit
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Hapus OTP lama untuk email ini, simpan yang baru
        DB::table('password_otp_codes')->where('email', $request->email)->delete();
        DB::table('password_otp_codes')->insert([
            'email'      => $request->email,
            'type'       => 'password_reset',
            'otp'        => $otp,
            'payload'    => null,
            'expires_at' => now()->addMinutes(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Kirim OTP via email
        try {
            Mail::to($request->email)->send(new OtpMail($otp, $request->email));
        } catch (\Exception $e) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Gagal mengirim email. Silakan coba lagi.']);
        }

        // Redirect ke halaman verifikasi OTP
        return redirect()->route('otp.verify.form', ['email' => $request->email])
            ->with('status', 'Kode OTP telah dikirim ke email Anda. Silakan periksa kotak masuk.');
    }
}
