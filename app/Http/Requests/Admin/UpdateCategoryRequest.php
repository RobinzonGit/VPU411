<?php

namespace App\Http\Requests\Admin;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the category being updated.
     */
    protected function category(): Category
    {
        return $this->route('category');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $category = $this->category();

        return [
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) use ($category) {
                    if ((int) $value === $category->id) {
                        $fail(
                            'Категория не может быть родительской для самой себя.'
                        );
                    }
                },
            ],

            'slug' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories', 'slug')
                    ->ignore($category->id),
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
