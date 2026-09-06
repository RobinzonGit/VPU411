<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $active = rand(0, 1);
        $title = 'Тестовая категория ' . rand(1, 10000000);
        $slug = Str::slug($title);

        return [
            'slug' => $slug,
            'title' => $title,
            'active' => $active
        ];
    }
}
