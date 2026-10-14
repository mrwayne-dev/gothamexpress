<?php

namespace App\Http\Controllers\Auth;

use App\Enums\VerificationCodeType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Models\User;
use App\Notifications\Auth\SendPasswordResetCode;
use App\Services\VerificationCodeService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ForgotPasswordController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    public function store(ForgotPasswordRequest $request, VerificationCodeService $codes): RedirectResponse
    {
        $email = $request->validated('email');

        // Always behave the same whether or not the account exists.
        $user = User::where('email', $email)->first();
        if ($user) {
            $code = $codes->issue($email, VerificationCodeType::PasswordReset);
            $user->notify(new SendPasswordResetCode(
                $code,
                (int) config('gotham.password_reset_code.expiry_minutes', 15),
                (int) config('gotham.password_reset_code.max_attempts', 5),
            ));
        }

        return redirect()->route('password.verify-code', ['email' => $email])
            ->with('info', 'If an account exists with that email, a code is on its way.');
    }
}
