<?php

namespace App\Http\Controllers\Auth;

use App\Enums\VerificationCodeType;
use App\Http\Controllers\Controller;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Notifications\Auth\SendEmailVerificationCode;
use App\Services\VerificationCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class VerifyEmailController extends Controller
{
    public function create(Request $request): Response|RedirectResponse
    {
        $user = $request->user();
        if ($user?->email_verified_at) {
            return redirect(RedirectIfAuthenticated::defaultFor($user->role));
        }
        return Inertia::render('Auth/VerifyEmail', [
            'email' => $user?->email,
        ]);
    }

    public function store(VerifyEmailRequest $request, VerificationCodeService $codes): RedirectResponse
    {
        $user = $request->user();

        $ok = $codes->verify($user->email, $request->string('code'), VerificationCodeType::EmailVerify);
        if (! $ok) {
            throw ValidationException::withMessages(['code' => 'That code is invalid or expired.']);
        }

        $user->forceFill(['email_verified_at' => now()])->save();
        return redirect(RedirectIfAuthenticated::defaultFor($user->role))
            ->with('success', 'Email verified.');
    }

    public function resend(Request $request, VerificationCodeService $codes): RedirectResponse
    {
        $user = $request->user();
        if ($user && ! $user->email_verified_at) {
            $code = $codes->issue($user->email, VerificationCodeType::EmailVerify);
            $user->notify(new SendEmailVerificationCode(
                $code,
                (int) config('gotham.verification_code.expiry_minutes', 60),
            ));
        }
        return back()->with('info', 'A new code has been sent if your account exists.');
    }
}
