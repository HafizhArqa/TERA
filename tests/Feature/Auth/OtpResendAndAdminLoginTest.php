<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Mail\OtpMail;
use App\Mail\RegisterOtpMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OtpResendAndAdminLoginTest extends TestCase
{
    public function test_admin_can_login_with_username_and_redirects_to_admin_dashboard(): void
    {
        $admin = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'email'    => 'admin@tera.com',
                'nama'     => 'Administrator',
                'password' => Hash::make('admin123'),
                'role'     => 'Admin',
            ]
        );

        $response = $this->post('/login', [
            'login'    => 'admin',
            'password' => 'admin123',
        ]);

        $this->assertAuthenticatedAs($admin);
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_can_login_with_email_and_redirects_to_admin_dashboard(): void
    {
        $admin = User::where('email', 'admin@tera.com')->first();

        $response = $this->post('/login', [
            'login'    => 'admin@tera.com',
            'password' => 'admin123',
        ]);

        $this->assertAuthenticatedAs($admin);
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_forgot_password_otp_can_be_resent(): void
    {
        Mail::fake();

        $user = User::firstOrCreate(
            ['email' => 'resend_test@tera.com'],
            [
                'username' => 'resenduser',
                'nama'     => 'Resend Tester',
                'password' => Hash::make('password123'),
                'role'     => 'Pelanggan',
            ]
        );

        // Kirim ulang OTP reset password
        $response = $this->post('/verify-otp/resend', [
            'email' => $user->email,
        ]);

        $response->assertRedirect(route('otp.verify.form', ['email' => $user->email]));
        $response->assertSessionHas('status', 'Kode OTP baru telah dikirim ke email Anda.');

        Mail::assertSent(OtpMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        $this->assertDatabaseHas('password_otp_codes', [
            'email' => $user->email,
            'type'  => 'password_reset',
        ]);
    }

    public function test_register_otp_can_be_resent(): void
    {
        Mail::fake();

        $email = 'register_resend@tera.com';
        
        // Simpan sesi pendaftaran pending
        DB::table('password_otp_codes')->where('email', $email)->delete();
        DB::table('password_otp_codes')->insert([
            'email'      => $email,
            'type'       => 'register',
            'otp'        => '111111',
            'payload'    => json_encode([
                'nama'     => 'Calon Pelanggan',
                'username' => 'calon_pelanggan',
                'email'    => $email,
                'password' => Hash::make('password123'),
            ]),
            'expires_at' => now()->addMinutes(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->post('/register/resend-otp', [
            'email' => $email,
        ]);

        $response->assertRedirect(route('register.otp.form', ['email' => $email]));
        $response->assertSessionHas('status', 'Kode OTP baru telah dikirim ke email Anda.');

        Mail::assertSent(RegisterOtpMail::class, function ($mail) use ($email) {
            return $mail->hasTo($email);
        });
    }
}
