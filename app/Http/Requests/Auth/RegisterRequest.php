<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'unique:users,email',
                'string',
                'email',
                'min: 5',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                'min:5',
                'max:255',
                'confirmed',
            ],
            'name' => [
                'required',
                'string',
                'min: 2',
                'max:255',
            ]
        ];
    }
}
