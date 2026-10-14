<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Requests\Auth\AdminRegisterRequest;
use App\Models\User;
use App\Services\InviteCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class AdminRegisterController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Auth/AdminRegister');
    }

    public function store(AdminRegisterRequest $request, InviteCodeService $invites): RedirectResponse
    {
        $data = $request->validated();

        $invite = $invites->find($data['invite_code']);
        if (! $invites->isUsable($invite)) {
            throw ValidationException::withMessages(['invite_code' => 'That invite code is invalid or expired.']);
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'location' => $data['location'],
            'password' => Hash::make($data['password']),
            'role' => $invite->tier->toRole(),
            'email_verified_at' => now(), // Invite flow implicitly trusts the email.
        ]);

        $invites->consume($invite, $user);

        Auth::login($user);
        return redirect(RedirectIfAuthenticated::defaultFor($user->role))
            ->with('success', 'Admin account created.');
    }
}
