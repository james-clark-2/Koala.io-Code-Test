<?php

namespace Models;

use App\Models\Location;
use App\Models\Menu;
use Tests\TestCase;

class MenuTest extends TestCase
{
    public function test_it_relates_to_a_location()
    {
        $menu = Menu::factory()->hasLocation()->create();

        $this->assertInstanceOf(Location::class, $menu->location);
    }
}
