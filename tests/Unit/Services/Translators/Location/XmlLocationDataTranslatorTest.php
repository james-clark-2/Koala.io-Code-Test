<?php

namespace Services\Translators\Location;

use App\Models\Location;
use App\Services\Translators\Location\XmlLocationDataTranslator;
use Tests\TestCase;
use Tests\Traits\GetsXmlTestFixtures;

class XmlLocationDataTranslatorTest extends TestCase
{
    use GetsXmlTestFixtures;

    public function test_it_can_translate_a_data_object_to_a_location_model()
    {
        $data = (object)$this->getXmlFixtureAsObject('koala-xml-grill-data')->{'@attributes'};

        $location = (new XmlLocationDataTranslator())->translate($data);

        $this->assertInstanceOf(Location::class, $location);
        $this->assertEquals($data->name, $location->name);
        $this->assertEquals($data->storename, $location->brand->pretty_name);
    }

    public function test_it_returns_null_when_it_cannot_parse_the_data_object_into_a_model()
    {
        $this->assertNull((new XmlLocationDataTranslator())->translate(new \stdClass()));
    }
}
