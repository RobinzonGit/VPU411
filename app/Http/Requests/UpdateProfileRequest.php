<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user()->id),
            ],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Укажите имя.',
            'email.required' => 'Укажите email.',
            'email.email' => 'Некорректный email.',
            'email.unique' => 'Такой email уже занят.',
            'avatar.image' => 'Аватар должен быть изображением.',
            'avatar.mimes' => 'Допустимые форматы: jpg, jpeg, png, webp.',
            'avatar.max' => 'Размер аватара не должен превышать 2 МБ.',
        ];
    }
}
