<?php

namespace Http\Controllers;

use App\Models\Brand;
use App\Models\Menu;
use Tests\TestCase;

class BrandControllerTest extends TestCase
{
    public function test_it_returns_paginated_brands()
    {
        $brand = Brand::factory()->count(26)->create();
        $this->get('/api/brands?per_page=25&page=2')
            ->assertOk()
            ->assertJsonPath('per_page', 25)
            ->assertJsonPath('current_page', 2);
    }

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
            ->assertNotFound()
            ->assertJson(['errors' => 'Brand not found.']);
    }

    public function test_it_returns_paginated_locations()
    {
        $brand = Brand::factory()->hasLocations(26)->create();
        $this->get('/api/'.$brand->brand_code.'/locations?per_page=25&page=2')
            ->assertOk()
            ->assertJsonPath('per_page', 25)
            ->assertJsonPath('current_page', 2);
    }

    public function test_it_returns_a_location()
    {
        $brand = Brand::factory()->hasLocations()->create();
        $this->get('/api/'.$brand->brand_code.'/locations/'.$brand->locations->first()->id)
            ->assertOk()
            ->assertJson($brand->locations->first()->toArray());
    }

    public function test_it_throws_404_for_a_missing_location()
    {
        $brand = Brand::factory()->hasLocations()->create();
        $this->get('/api/'.$brand->brand_code.'/locations/not_a_location_id')
            ->assertNotFound()
            ->assertJson(['errors' => 'Location not found.']);
    }

    public function test_it_returns_a_menu_with_categories_and_items_for_a_location()
    {
        $brand = Brand::factory()->hasLocations()->create();

        $location = $brand->locations->first();
        $location->menu()->associate(Menu::factory()->withCategoriesAndItems()->create());
        $location->save();

        $this->get('/api/'.$brand->brand_code.'/locations/'.$brand->locations->first()->id.'/menu')
            ->assertOk()
            ->assertJson($brand->locations()->first()->menu()->with('categories.items')->get()->toArray());
    }

    public function test_it_throws_404_for_a_missing_menu()
    {
        $brand = Brand::factory()->hasLocations()->create();
        $this->get('/api/'.$brand->brand_code.'/locations/not_a_location_id/menu')
            ->assertNotFound()
            ->assertJson(['errors' => 'Location not found.']);
    }
}
