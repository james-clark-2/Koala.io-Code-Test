<?php

namespace Tests\Feature\Services\Parsers;

use App\Models\Location;
use App\Services\Parsers\XmlLocationFeedParser;
use App\Services\Parsers\LocationFeedParser;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Tests\Traits\UsesJsonTestFixtures;

class XmlLocationFeedParserTest extends TestCase
{
    use UsesJsonTestFixtures;

    public function test_it_is_instantiable()
    {
        $this->assertInstanceOf(LocationFeedParser::class, app(XmlLocationFeedParser::class));
    }

    public function test_it_parses_a_xml_list_of_locations()
    {
        /** @var LocationFeedParser $parser */
        $parser = app(XmlLocationFeedParser::class);

        $locations = $parser->parse(base_path('tests/Fixtures/koala-xml-grill-data.xml'));

        $this->assertInstanceOf(Collection::class, $locations);
        $this->assertNotEmpty($locations);
        $this->assertContainsOnlyInstancesOf(Location::class, $locations);
    }
}
