<?php

namespace Console\Commands;

use App\Models\Location;
use App\Services\Parsers\JsonLocationFeedParser;
use App\Services\Parsers\XmlLocationFeedParser;
use Mockery;

class ImportCommandTest extends \Tests\TestCase
{
    public function test_it_accepts_a_list_of_files()
    {
        $path = base_path('tests/Fixtures/koala-json-eatery-location.json');
        $this->artisan('koala:import', ['files' => [$path]]);

        $this->assertDatabaseHas('locations', ['feed_id' => 2]);
    }

    public function test_it_uses_the_json_parser_for_json_files()
    {
        $paths = [
            base_path('tests/Fixtures/koala-json-eatery-location.json'),
            base_path('tests/Fixtures/koala-json-eatery-menu.json')
        ];

        $parserSpy = Mockery::spy(app(JsonLocationFeedParser::class))->makePartial();
        $this->app->bind(
            JsonLocationFeedParser::class,
            fn() => $parserSpy
        );

        $this->artisan('koala:import', ['files' => $paths]);

        foreach ($paths as $path) {
            $parserSpy->shouldHaveReceived('parse')->with($path)->once();
        }
    }

    public function test_it_uses_the_xml_parser_for_xml_files()
    {
        $path = base_path('tests/Fixtures/koala-xml-grill-data.xml');

        $parserSpy = Mockery::spy(app(XmlLocationFeedParser::class))->makePartial();
        $this->app->bind(
            XmlLocationFeedParser::class,
            fn() => $parserSpy
        );

        $this->artisan('koala:import', ['files' => [$path]]);

        $parserSpy->shouldHaveReceived('parse')->once()->with($path);
    }

    public function test_it_updates_records_with_the_same_feed_id()
    {
        $expectedFeedId = 2; //Matches id in the fixture
        $oldLocation = Location::factory()->create(['feed_id' => $expectedFeedId]);

        $path = base_path('tests/Fixtures/koala-json-eatery-location.json');
        $this->artisan('koala:import', ['files' => [$path]]);

        $this->assertCount(1, Location::where('feed_id', $expectedFeedId)->get());
        $newLocation = Location::where('feed_id', $expectedFeedId)->first();
        $this->assertNotEquals($oldLocation->name, $newLocation->name);
        $this->assertNotEquals($oldLocation->phone_number, $newLocation->phone_number);
    }
}
