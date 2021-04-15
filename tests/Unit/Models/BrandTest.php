<?php

namespace Tests\Unit\Models;

use App\Models\Location;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

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

    public function test_it_can_find_by_name()
    {
        $brand = Brand::factory()->create();
        $foundBrand = Brand::findByName($brand->pretty_name);

        $this->assertTrue($foundBrand->is($brand));
    }

    public function test_it_can_scope_by_code()
    {
        $expectedBrand = Brand::factory()->create([
            'brand_code' => 'find_me',
            'pretty_name' => 'Find Me'
        ]);

        $unexpectedBrand = Brand::factory()->create([
            'brand_code' => 'do_not_find_me',
            'pretty_name' => 'Do Not Find Me'
        ]);

        $brand = Brand::brandCode('find_me')->firstOrFail();

        $this->assertTrue($brand->is($expectedBrand));
        $this->assertTrue($brand->isNot($unexpectedBrand));
    }

    public function test_it_returns_the_same_model_on_repeated_by_name_lookups()
    {
        $name = Brand::factory()->create()->pretty_name;

        $foundBrand1 = Brand::findByName($name);
        $foundBrand2 = Brand::findByName($name);

        $this->assertSame($foundBrand1, $foundBrand2);
    }

    public function location_count_provider(): array
    {
        return [
            [1], [2], [3]
        ];
    }
}
