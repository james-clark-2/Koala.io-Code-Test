<?php

namespace Services\Translators\Location;

use App\Models\Location;
use App\Services\Translators\Location\ConfigurableLocationDataTranslator;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use Tests\Traits\UsesXmlTestFixtures;
use Tests\Traits\UsesJsonTestFixtures;

class ConfigurableLocationDataTranslatorTest extends TestCase
{
    use UsesXmlTestFixtures;
    use UsesJsonTestFixtures;

    /**
     * @param $data
     * @param $configuration
     * @dataProvider configuration_and_location_data_provider
     */
    public function test_it_can_translate_a_data_object_to_a_location_model(\stdClass $data, array $configuration)
    {
        $location = (new ConfigurableLocationDataTranslator($configuration))->translate($data);

        $this->assertInstanceOf(Location::class, $location);

        foreach ($configuration['map'] as $modelAttribute => $dataAttribute) {
            $this->assertEquals($data->{$dataAttribute['field']}, $location->$modelAttribute);
        }
    }

    /**
     * @dataProvider configuration_and_location_data_provider
     */
    public function test_it_throws_a_validation_exception_when_it_fails_validation($data, $configuration)
    {
        $this->expectException(ValidationException::class);
        (new ConfigurableLocationDataTranslator($configuration))->translate(new \stdClass());
    }

    public function configuration_and_location_data_provider()
    {
        $this->createApplication();
        return [
            'XML Configuration' => [
                (object)$this->getXmlFixtureAsObject('koala-xml-grill-data')->{'@attributes'},
                [
                    'map' => [
                        'feed_id' => [
                            'field' => 'id',
                            'rules' => 'required|int'
                        ],
                        'name' => [
                            'field' => 'name',
                            'rules' => 'required'
                        ],
                        'phone_number' => [
                            'field' => 'telephone',
                            'rules' => 'required'
                        ]
                    ],
                    'brand_identifier' => 'storename'
                ]
            ],
            'Json Configuration' => [
                (object)$this->getJsonFixtureAsObject('koala-json-eatery-location')->locations[0],
                [
                    'map' => [
                        'feed_id' => [
                            'field' => 'id',
                            'rules' => 'required|int'
                        ],
                        'name' => [
                            'field' => 'name',
                            'rules' => 'required'
                        ],
                        'phone_number' => [
                            'field' => 'phone_number',
                            'rules' => 'required'
                        ],
                        'description' => [
                            'field' => 'description',
                        ]
                    ],
                    'brand_identifier' => 'business_name'
                ]
            ]
        ];
    }
}
