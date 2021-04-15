<?php

namespace Tests\Unit\Models;

use App\Models\Brand;
use App\Models\Location;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LocationTest extends \Tests\TestCase
{
    public function test_it_belongs_to_a_brand()
    {
        $location = Location::factory()->forBrand()->create();

        $this->assertInstanceOf(BelongsTo::class, $location->brand());
        $this->assertNotNull($location->brand);
        $this->assertInstanceOf(Brand::class, $location->brand);
    }
}
