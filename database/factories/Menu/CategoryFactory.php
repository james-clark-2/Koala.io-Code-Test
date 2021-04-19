<?php

namespace Database\Factories\Menu;

use App\Models\Menu;
use App\Models\Menu\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->catchPhrase,
            'feed_id' => $this->faker->lexify('??????'),
            'menu_id' => Menu::query()->inRandomOrder()->first()?->id
        ];
    }
}
