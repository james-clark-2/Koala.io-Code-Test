<?php

namespace Tests\Feature\Services\Parsers;

use App\Models\Menu;
use App\Services\Parsers\FeedParser;
use App\Services\Parsers\JsonMenuFeedParser;
use App\Services\Parsers\XmlMenuFeedParser;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Tests\Traits\UsesJsonTestFixtures;

class XmlMenuFeedParserTest extends TestCase
{
    use UsesJsonTestFixtures;

    public function test_it_is_instantiable()
    {
        $this->assertInstanceOf(FeedParser::class, app(XmlMenuFeedParser::class));
    }

    public function test_it_parses_a_xml_menu_containing_categories_and_items()
    {
        /** @var FeedParser $parser */
        $parser = app(XmlMenuFeedParser::class);

        $menus = $parser->parse(base_path('tests/Fixtures/koala-xml-grill-data.xml'));

        $this->assertInstanceOf(Collection::class, $menus);
        $this->assertNotEmpty($menus);
        $this->assertContainsOnlyInstancesOf(Menu::class, $menus);

        $menu = $menus->first()->refresh();
        $this->assertNotEmpty($menu->categories);
        $menu->categories->each(
            function ($category) use ($menu) {
                $this->assertTrue($category->menu->is($menu));

                //Matches category feed id found in fixture
                $categoryIdsNotContainingItems = ['UPHBRYLO2IR6HYJCFS6BT7WR'];

                if (in_array($category->feed_id, $categoryIdsNotContainingItems)) {
                    $this->assertEmpty($category->items);
                } else {
                    $this->assertNotEmpty($category->items);
                }
            }
        );
    }
}
