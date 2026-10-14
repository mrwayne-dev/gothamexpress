<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use App\Notifications\Auth\PasswordChanged;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class ResetPasswordController extends Controller
{
    public function create(Request $request): Response|RedirectResponse
    {
        $email = $request->session()->get('pw-reset.email');
        $verifiedAt = $request->session()->get('pw-reset.verified_at');
        if (! $email || ! $verifiedAt || now()->timestamp - $verifiedAt > 900) {
            return redirect()->route('password.request')->with('error', 'Verify your reset code first.');
        }
        return Inertia::render('Auth/ResetPassword', ['email' => $email]);
    }

    public function store(ResetPasswordRequest $request): RedirectResponse
    {
        $email = $request->session()->get('pw-reset.email');
        $verifiedAt = $request->session()->get('pw-reset.verified_at');
        if (! $email || ! $verifiedAt || now()->timestamp - $verifiedAt > 900) {
            return redirect()->route('password.request')->with('error', 'Reset window expired. Request a new code.');
        }

        $user = User::where('email', $email)->first();
        if (! $user) {
            return redirect()->route('password.request')->with('error', 'Account not found.');
        }

        $user->forceFill(['password' => Hash::make($request->validated('password'))])->save();
        $user->notify(new PasswordChanged);

        $request->session()->forget(['pw-reset.email', 'pw-reset.verified_at']);
        Auth::login($user);
        $request->session()->regenerate();

        return redirect(RedirectIfAuthenticated::defaultFor($user->role))
            ->with('success', 'Password updated.');
    }
}
