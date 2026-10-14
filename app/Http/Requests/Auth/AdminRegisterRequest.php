<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AdminRegisterRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:191', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:40'],
            'location' => ['required', 'string', 'max:191'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'invite_code' => ['required', 'string', 'max:32'],
        ];
    }
}
