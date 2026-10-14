<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Enums\VerificationCodeType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Notifications\Auth\SendEmailVerificationCode;
use App\Services\VerificationCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class RegisterController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function store(RegisterRequest $request, VerificationCodeService $codes): RedirectResponse
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'location' => $data['location'],
            'password' => Hash::make($data['password']),
            'role' => UserRole::User,
        ]);

        $code = $codes->issue($user->email, VerificationCodeType::EmailVerify);
        $user->notify(new SendEmailVerificationCode(
            $code,
            (int) config('gotham.verification_code.expiry_minutes', 60),
        ));

        Auth::login($user);
        return redirect()->route('verification.notice')
            ->with('success', 'Account created. Check your email for a 6-digit code.');
    }
}
