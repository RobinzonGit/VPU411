<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'parent_id' => [
                'nullable',
                'exists:categories,id',
            ],

            'slug' => [
                'required',
                'string',
                'max:100',
                'unique:categories,slug',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'active' => [
                'boolean',
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'active' => $this->boolean('active'),
        ]);
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'parent_id.exists' => 'Выбранная родительская категория не существует.',

            'slug.required' => 'Введите slug категории.',
            'slug.unique' => 'Категория с таким slug уже существует.',
            'slug.max' => 'Slug не может содержать более 100 символов.',

            'title.required' => 'Введите название категории.',
            'title.max' => 'Название не может содержать более 255 символов.',
        ];
    }
}
