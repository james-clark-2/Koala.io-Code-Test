<?php

namespace Models\Menu;

use App\Models\Menu;
use App\Models\Menu\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function test_it_relates_to_a_menu()
    {
        $category = Category::factory()->forMenu()->create();

        $this->assertInstanceOf(Menu::class, $category->menu);
    }

    /**
     * @dataProvider item_count_provider
     */
    public function test_it_has_one_or_more_items(int $itemCount)
    {
        $category = Category::factory()->forMenu()->hasItems($itemCount)->create();

        $this->assertNotEmpty($category->items);
        $this->assertCount($itemCount, $category->items);
    }

    public function item_count_provider()
    {
        return [[1], [3], [5]];
    }
}
