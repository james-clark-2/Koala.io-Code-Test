<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Location;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->catchPhrase,
            'phone_number' => $this->faker->phoneNumber,
            'feed_id' => $this->faker->numberBetween(),
            'brand_id' => Brand::query()->latest()->first()->id,
        ];
    }
}
