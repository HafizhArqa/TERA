<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // update pass to database, Otherwise it will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        $messages = [
            Password::PASSWORD_RESET => 'Kata sandi Anda berhasil diperbarui! Silakan masuk dengan kata sandi baru Anda.',
            Password::INVALID_USER => 'Pengguna dengan email tersebut tidak ditemukan.',
            Password::INVALID_TOKEN => 'Tautan atau token reset kata sandi ini tidak valid atau telah kedaluwarsa.',
            Password::RESET_THROTTLED => 'Mohon tunggu beberapa saat sebelum mencoba kembali.',
        ];

        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', $messages[$status] ?? __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => $messages[$status] ?? __($status)]);
    }
}
