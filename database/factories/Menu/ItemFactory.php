<?php

namespace Database\Factories\Menu;

use App\Models\Menu\Category;
use App\Models\Menu\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $category = Category::query()->inRandomOrder()->first();
        return [
            'name' => $this->faker->catchPhrase,
            'description' => $this->faker->catchPhrase,
            'category_id' => $category->id,
            'category_feed_id' => $category->feed_id,
            'feed_id' => $this->faker->lexify('???????'),
            'active' => $this->faker->boolean
        ];
    }
}
