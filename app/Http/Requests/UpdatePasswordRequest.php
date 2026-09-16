<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Введите текущий пароль.',
            'current_password.current_password' => 'Текущий пароль указан неверно.',
            'password.required' => 'Введите новый пароль.',
            'password.confirmed' => 'Пароли не совпадают.',
            'password.min' => 'Пароль должен быть не короче :min символов.',
        ];
    }
}
