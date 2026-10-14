<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'firstname' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:191'],
            'inquiry' => ['required', 'in:general,tracking,shipping,partnership,complaint'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ];
    }
}
