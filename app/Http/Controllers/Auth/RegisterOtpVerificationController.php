<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegisterOtpMail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class RegisterOtpVerificationController extends Controller
{
    /**
     * Tampilkan halaman verifikasi OTP register.
     */
    public function show(Request $request): View
    {
        $email = $request->query('email') ?: session('register_otp_email', '');
        if ($email) {
            session(['register_otp_email' => $email]);
        }

        return view('auth.verify-register-otp', [
            'email' => $email,
        ]);
    }

    /**
     * Verifikasi OTP dan buat akun jika valid.
     */
    public function verify(Request $request): RedirectResponse
    {
        $email = $request->input('email') ?: session('register_otp_email');
        $request->merge(['email' => $email]);

        $request->validate([
            'email' => ['required', 'email'],
            'otp'   => ['required', 'string', 'size:6'],
        ]);

        $record = DB::table('password_otp_codes')
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('type', 'register')
            ->first();

        // OTP tidak ditemukan
        if (!$record) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['otp' => 'Kode OTP tidak valid. Periksa kembali kode yang Anda masukkan.']);
        }

        // OTP sudah expired
        if (now()->isAfter($record->expires_at)) {
            DB::table('password_otp_codes')->where('id', $record->id)->delete();
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['otp' => 'Kode OTP sudah kedaluwarsa. Silakan daftar ulang.']);
        }

        // OTP valid — hapus record, buat akun
        DB::table('password_otp_codes')->where('id', $record->id)->delete();
        session()->forget('register_otp_email');

        $data = json_decode($record->payload, true);

        // Buat user
        $user = User::create([
            'nama'     => $data['nama'],
            'username' => $data['username'],
            'email'    => $data['email'],
            'password' => $data['password'], // sudah di-hash sebelumnya
            'role'     => 'Pelanggan',
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('pelanggan.dashboard')
            ->with('status', 'Akun berhasil dibuat! Selamat datang di TERA.');
    }

    /**
     * Kirim ulang OTP register.
     */
    public function resend(Request $request): RedirectResponse
    {
        $email = $request->input('email') ?: session('register_otp_email');
        if (!$email) {
            return redirect()->route('register')
                ->withErrors(['email' => 'Sesi pendaftaran tidak ditemukan. Silakan daftar ulang.']);
        }

        $record = DB::table('password_otp_codes')
            ->where('email', $email)
            ->where('type', 'register')
            ->first();

        if (!$record) {
            return redirect()->route('register')
                ->withErrors(['email' => 'Sesi pendaftaran tidak ditemukan. Silakan daftar ulang.']);
        }

        // Generate OTP baru
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $payload = json_decode($record->payload, true);

        DB::table('password_otp_codes')
            ->where('id', $record->id)
            ->update([
                'otp'        => $otp,
                'expires_at' => now()->addMinutes(10),
                'updated_at' => now(),
            ]);

        session(['register_otp_email' => $email]);

        try {
            Mail::to($email)->send(new RegisterOtpMail($otp, $payload['nama']));
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim ulang OTP: ' . $e->getMessage()]);
        }

        return redirect()->route('register.otp.form', ['email' => $email])
            ->with('status', 'Kode OTP baru telah dikirim ke email Anda.');
    }
}
