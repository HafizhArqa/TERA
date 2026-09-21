<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    /**
     * Tampilkan form input OTP.
     */
    public function show(Request $request): View
    {
        $email = $request->query('email') ?: session('otp_email', '');
        if ($email) {
            session(['otp_email' => $email]);
        }

        return view('auth.verify-otp', [
            'email' => $email,
        ]);
    }

    /**
     * Verifikasi kode OTP yang diinput user.
     */
    public function verify(Request $request): RedirectResponse
    {
        $email = $request->input('email') ?: session('otp_email');
        $request->merge(['email' => $email]);

        $request->validate([
            'email' => ['required', 'email'],
            'otp'   => ['required', 'string', 'size:6'],
        ]);

        $record = DB::table('password_otp_codes')
            ->where('email', $request->email)
            ->where('type', 'password_reset')
            ->where('otp', $request->otp)
            ->first();

        // OTP tidak ditemukan
        if (!$record) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['otp' => 'Kode OTP tidak valid. Periksa kembali kode yang Anda masukkan.']);
        }

        // OTP expired
        if (now()->isAfter($record->expires_at)) {
            DB::table('password_otp_codes')->where('id', $record->id)->delete();
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['otp' => 'Kode OTP sudah kedaluwarsa. Silakan minta kode baru.']);
        }

        // OTP valid generate reset token Laravel
        DB::table('password_otp_codes')->where('id', $record->id)->delete();
        session()->forget('otp_email');

        $token = app('auth.password.broker')->createToken(
            \App\Models\User::where('email', $request->email)->firstOrFail()
        );

        return redirect()->route('password.reset', ['token' => $token])
            ->withInput(['email' => $request->email]);
    }

    /**
     * Kirim ulang OTP reset password.
     */
    public function resend(Request $request): RedirectResponse
    {
        $email = $request->input('email') ?: session('otp_email');
        if (!$email) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Sesi verifikasi telah berakhir. Silakan masukkan email Anda kembali.']);
        }

        $user = \App\Models\User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Email tidak ditemukan. Silakan coba lagi.']);
        }

        // Generate OTP baru
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Hapus OTP lama, simpan yang baru
        DB::table('password_otp_codes')->where('email', $email)->delete();
        DB::table('password_otp_codes')->insert([
            'email'      => $email,
            'type'       => 'password_reset',
            'otp'        => $otp,
            'payload'    => null,
            'expires_at' => now()->addMinutes(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        session(['otp_email' => $email]);

        try {
            Mail::to($email)->send(new OtpMail($otp, $email));
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim ulang OTP: ' . $e->getMessage()]);
        }

        return redirect()->route('otp.verify.form', ['email' => $email])
            ->with('status', 'Kode OTP baru telah dikirim ke email Anda.');
    }
}
