<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Смартфоны', 'is_active' => true],
            ['name' => 'Ноутбуки', 'is_active' => true],
            ['name' => 'Планшеты', 'is_active' => true],
            ['name' => 'Наушники', 'is_active' => true],
            ['name' => 'Акустические системы', 'is_active' => true],
            ['name' => 'Телевизоры', 'is_active' => true],
            ['name' => 'Мониторы', 'is_active' => true],
            ['name' => 'Клавиатуры', 'is_active' => true],
            ['name' => 'Мыши', 'is_active' => true],
            ['name' => 'Внешние накопители', 'is_active' => true],
            ['name' => 'Зарядные устройства', 'is_active' => true],
            ['name' => 'Пауэрбанки', 'is_active' => true],
            ['name' => 'Кабели и переходники', 'is_active' => true],
            ['name' => 'Сетевые фильтры', 'is_active' => true],
            ['name' => 'Роутеры', 'is_active' => true],
            ['name' => 'Умные часы', 'is_active' => true],
            ['name' => 'Фитнес-браслеты', 'is_active' => true],
            ['name' => 'Игровые приставки', 'is_active' => true],
            ['name' => 'Электронные книги', 'is_active' => true],
            ['name' => 'Комплектующие для ПК', 'is_active' => true],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate([
                'name' => $category['name'],
            ], $category);
        }
    }
}
