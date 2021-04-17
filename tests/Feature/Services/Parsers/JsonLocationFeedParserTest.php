<?php

namespace Tests\Feature\Services\Parsers;

use App\Models\Location;
use App\Services\Parsers\JsonLocationFeedParser;
use App\Services\Parsers\FeedParser;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Tests\Traits\UsesJsonTestFixtures;

class JsonLocationFeedParserTest extends TestCase
{
    use UsesJsonTestFixtures;

    public function test_it_is_instantiable()
    {
        $this->assertInstanceOf(FeedParser::class, app(JsonLocationFeedParser::class));
    }

    public function test_it_parses_a_json_list_of_locations()
    {
        /** @var FeedParser $parser */
        $parser = app(JsonLocationFeedParser::class);

        $locations = $parser->parse(base_path('tests/Fixtures/koala-json-eatery-location.json'));

        $this->assertInstanceOf(Collection::class, $locations);
        $this->assertNotEmpty($locations);
        $this->assertContainsOnlyInstancesOf(Location::class, $locations);
    }
}
