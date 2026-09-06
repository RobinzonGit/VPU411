<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Корневые категории (parent_id = null)
        $electronics = Category::firstOrCreate(
            ['slug' => 'electronics'],
            [
                'parent_id' => null,
                'title' => 'Электроника',
                'active' => true,
            ]
        );

        $clothing = Category::firstOrCreate(
            ['slug' => 'clothing'],
            [
                'parent_id' => null,
                'title' => 'Одежда',
                'active' => true,
            ]
        );

        $footwear = Category::firstOrCreate(
            ['slug' => 'footwear'],
            [
                'parent_id' => null,
                'title' => 'Обувь',
                'active' => true,
            ]
        );

        $accessories = Category::firstOrCreate(
            ['slug' => 'accessories'],
            [
                'parent_id' => null,
                'title' => 'Аксессуары',
                'active' => true,
            ]
        );

        $home = Category::firstOrCreate(
            ['slug' => 'home'],
            [
                'parent_id' => null,
                'title' => 'Для дома',
                'active' => true,
            ]
        );

        $books = Category::firstOrCreate(
            ['slug' => 'books'],
            [
                'parent_id' => null,
                'title' => 'Книги',
                'active' => true,
            ]
        );

        // Подкатегории Электроники
        Category::firstOrCreate(
            ['slug' => 'smartphones'],
            [
                'parent_id' => $electronics->id,
                'title' => 'Смартфоны',
                'active' => true,
            ]
        );

        Category::firstOrCreate(
            ['slug' => 'laptops'],
            [
                'parent_id' => $electronics->id,
                'title' => 'Ноутбуки',
                'active' => true,
            ]
        );

        Category::firstOrCreate(
            ['slug' => 'headphones'],
            [
                'parent_id' => $electronics->id,
                'title' => 'Наушники',
                'active' => true,
            ]
        );

        Category::firstOrCreate(
            ['slug' => 'tablets'],
            [
                'parent_id' => $electronics->id,
                'title' => 'Планшеты',
                'active' => true,
            ]
        );

        // Подкатегории Одежды
        Category::firstOrCreate(
            ['slug' => 'mens-clothing'],
            [
                'parent_id' => $clothing->id,
                'title' => 'Мужская одежда',
                'active' => true,
            ]
        );

        Category::firstOrCreate(
            ['slug' => 'womens-clothing'],
            [
                'parent_id' => $clothing->id,
                'title' => 'Женская одежда',
                'active' => true,
            ]
        );

        Category::firstOrCreate(
            ['slug' => 'kids-clothing'],
            [
                'parent_id' => $clothing->id,
                'title' => 'Детская одежда',
                'active' => true,
            ]
        );

        // Подкатегории Обуви
        Category::firstOrCreate(
            ['slug' => 'sneakers'],
            [
                'parent_id' => $footwear->id,
                'title' => 'Кроссовки',
                'active' => true,
            ]
        );

        Category::firstOrCreate(
            ['slug' => 'boots'],
            [
                'parent_id' => $footwear->id,
                'title' => 'Ботинки',
                'active' => true,
            ]
        );

        Category::firstOrCreate(
            ['slug' => 'shoes'],
            [
                'parent_id' => $footwear->id,
                'title' => 'Туфли',
                'active' => true,
            ]
        );

        $this->command->info('Категории успешно созданы!');
    }
}
