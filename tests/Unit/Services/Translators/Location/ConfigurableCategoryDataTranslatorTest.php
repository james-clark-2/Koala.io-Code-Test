<?php

namespace Services\Translators\Location;

use App\Models\Menu\Category;
use App\Services\Translators\Category\ConfigurableCategoryDataTranslator;
use App\Services\Translators\Location\ConfigurableLocationDataTranslator;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use Tests\Traits\UsesXmlTestFixtures;
use Tests\Traits\UsesJsonTestFixtures;

class ConfigurableCategoryDataTranslatorTest extends TestCase
{
    use UsesXmlTestFixtures;
    use UsesJsonTestFixtures;

    /**
     * @param $data
     * @param $configuration
     * @dataProvider configuration_and_location_data_provider
     */
    public function test_it_can_translate_a_data_object_to_a_category_model(\stdClass $data, array $configuration)
    {
        $location = (new ConfigurableCategoryDataTranslator($configuration))->translate($data);

        $this->assertInstanceOf(Category::class, $location);

        $dataAsArray = json_decode(json_encode($data), true);
        foreach ($configuration['map'] as $modelAttribute => $dataAttribute) {
            $this->assertEquals(Arr::get($dataAsArray, $dataAttribute['field']), $location->$modelAttribute);
        }
    }

    /**
     * @dataProvider configuration_and_location_data_provider
     */
    public function test_it_throws_a_validation_exception_when_it_fails_validation($data, $configuration)
    {
        $this->expectException(ValidationException::class);
        (new ConfigurableCategoryDataTranslator($configuration))->translate(new \stdClass());
    }

    public function configuration_and_location_data_provider()
    {
        $this->createApplication();
        return [
            'XML Configuration' => [
                json_decode(json_encode($this->getXmlFixtureAsObject('koala-xml-grill-data')->menu->categories->category[0]))->{'@attributes'},
                [
                    'map' => [
                        'feed_id' => [
                            'field' => 'id',
                            'rules' => 'required|string'
                        ],
                        'name' => [
                            'field' => 'name',
                            'rules' => 'required'
                        ]
                    ]
                ]
            ],
            'Json Configuration' => [
                (object)$this->getJsonFixtureAsObject('koala-json-eatery-menu')->objects[0],
                [
                    'map' => [
                        'feed_id' => [
                            'field' => 'id',
                            'rules' => 'required|string'
                        ],
                        'name' => [
                            'field' => 'category_data.name',
                            'rules' => 'required'
                        ]
                    ]
                ]
            ]
        ];
    }
}
