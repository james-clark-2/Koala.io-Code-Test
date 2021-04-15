<?php

namespace Tests\Feature\Services\Parsers;

use App\Models\Location;
use App\Services\Parsers\JsonLocationFeedParser;
use Tests\TestCase;
use Tests\Traits\GetsJsonTestFixtures;

class JsonLocationFeedParserTest extends TestCase
{
    use GetsJsonTestFixtures;

    public function test_it_parses_a_json_list_of_locations()
    {
        //$this->getJsonFixture('koala-json-eatery-location');
        /** @var JsonLocationFeedParser $parser */
        $parser = app(JsonLocationFeedParser::class);

        $locations = $parser->parse(base_path('tests/Fixtures/koala-json-eatery-location.json'));

        $this->assertIsArray($locations);
        $this->assertNotEmpty($locations);
        $this->assertContainsOnlyInstancesOf(Location::class, $locations);
    }
}
