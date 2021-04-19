<?php

namespace Http\Controllers;

use App\Models\Brand;

class BrandControllerTest extends \Tests\TestCase
{
    public function test_it_returns_a_brand()
    {
        $brand = Brand::factory()->create();
        $this->get('/api/'.$brand->brand_code)
            ->assertOk()
            ->assertJson($brand->toArray());
    }

    public function test_it_throws_404_when_the_brand_does_not_exist()
    {
        $this->get('/api/not_a_real_brand')
            ->assertNotFound();
    }

    public function test_it_returns_paginated_locations()
    {
        $brand = Brand::factory()->hasLocations(26)->create();
        $this->get('/api/'.$brand->brand_code.'/locations?per_page=25')
            ->assertOk()
            ->assertSimilarJson(['per_page' => 25])
            ->assertJsonPath('current_page', 1);
    }

    public function test_it_returns_a_location()
    {
        $brand = Brand::factory()->hasLocations()->create();
        $this->get('/api/'.$brand->brand_code.'/locations/'.$brand->locations->first()->id)
            ->assertOk()
            ->assertJson($brand->toArray());
    }
}
