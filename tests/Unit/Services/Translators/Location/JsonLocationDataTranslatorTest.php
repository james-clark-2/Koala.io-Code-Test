<?php

namespace Services\Translators\Location;

use App\Models\Location;
use App\Services\Translators\Location\JsonLocationDataTranslator;
use Tests\TestCase;
use Tests\Traits\GetsJsonTestFixtures;

class JsonLocationDataTranslatorTest extends TestCase
{
    use GetsJsonTestFixtures;

    public function test_it_can_translate_a_data_object_to_a_location_model()
    {
        $data = $this->getJsonFixtureAsObject('koala-json-eatery-location')->locations[0];

        $location = (new JsonLocationDataTranslator())->translate($data);

        $this->assertInstanceOf(Location::class, $location);
        $this->assertEquals($data->name, $location->name);
        $this->assertEquals($data->business_name, $location->brand->pretty_name);
    }

    public function test_it_returns_null_when_it_cannot_parse_the_data_object_into_a_model()
    {
        $this->assertNull((new JsonLocationDataTranslator())->translate(new \stdClass()));
    }
}
