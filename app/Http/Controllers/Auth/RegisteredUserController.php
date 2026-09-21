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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     * Validate data, generate OTP, save pending data, send email OTP.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama'     => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:' . User::class],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:100', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Generate OTP 6 digit
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Payload data register (password sudah di-hash)
        $payload = json_encode([
            'nama'     => $request->nama,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Hapus OTP lama untuk email ini, simpan yang baru
        DB::table('password_otp_codes')->where('email', $request->email)->delete();
        DB::table('password_otp_codes')->insert([
            'email'      => $request->email,
            'type'       => 'register',
            'otp'        => $otp,
            'payload'    => $payload,
            'expires_at' => now()->addMinutes(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Kirim OTP via email
        try {
            Mail::to($request->email)->send(new RegisterOtpMail($otp, $request->nama));
        } catch (\Exception $e) {
            DB::table('password_otp_codes')->where('email', $request->email)->delete();
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['email' => 'Gagal mengirim email verifikasi. Silakan coba lagi.']);
        }

        // Redirect ke halaman verifikasi OTP register
        return redirect()->route('register.otp.form', ['email' => $request->email])
            ->with('status', 'Kode OTP telah dikirim ke email Anda. Silakan periksa kotak masuk atau kotak spam untuk mengaktifkan akun.');
    }
}
