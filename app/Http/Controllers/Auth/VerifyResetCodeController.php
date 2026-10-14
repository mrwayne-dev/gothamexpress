<?php

namespace App\Http\Controllers\Auth;

use App\Enums\VerificationCodeType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyResetCodeRequest;
use App\Services\VerificationCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class VerifyResetCodeController extends Controller
{
    public function create(Request $request): Response
    {
        return Inertia::render('Auth/VerifyResetCode', [
            'email' => $request->query('email'),
        ]);
    }

    public function store(VerifyResetCodeRequest $request, VerificationCodeService $codes): RedirectResponse
    {
        $email = $request->validated('email');
        $code = $request->validated('code');

        if (! $codes->verify($email, $code, VerificationCodeType::PasswordReset)) {
            throw ValidationException::withMessages(['code' => 'That code is invalid or expired.']);
        }

        // Issue a signed, short-lived flag in the session so Reset can proceed.
        $request->session()->put('pw-reset.email', $email);
        $request->session()->put('pw-reset.verified_at', now()->timestamp);

        return redirect()->route('password.reset')->with('success', 'Code verified. Set your new password.');
    }
}
