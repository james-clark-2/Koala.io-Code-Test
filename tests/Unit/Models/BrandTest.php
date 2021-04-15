<?php

namespace Tests\Unit\Models;

use App\Models\Location;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class RestaurantTest
 * @package Tests\Unit\Models
 */
class BrandTest extends \Tests\TestCase
{
    /**
     * @dataProvider location_count_provider
     */
    public function test_it_has_locations(int $count)
    {
        $restaurant = Brand::factory()->hasLocations($count)->create();

        $this->assertInstanceOf(HasMany::class, $restaurant->locations());
        $this->assertCount($count, $restaurant->locations);
        $this->assertContainsOnlyInstancesOf(Location::class, $restaurant->locations);
    }

    public function location_count_provider(): array
    {
        return [
            [1], [2], [3]
        ];
    }
}
