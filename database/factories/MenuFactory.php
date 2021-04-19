<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Menu\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Menu::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

        ];
    }

    public function withCategoriesAndItems($categoryCount = 1, $itemCountPerCategory = 1)
    {
        return $this->afterCreating(function (Menu $menu) use ($categoryCount, $itemCountPerCategory) {
           Category::factory()->count($categoryCount)->hasItems($itemCountPerCategory)->create([
               'menu_id' => $menu->id
           ]);
        });
    }
}
