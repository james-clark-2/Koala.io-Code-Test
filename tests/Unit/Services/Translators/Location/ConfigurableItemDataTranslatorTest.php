<?php

namespace Services\Translators\Location;

use App\Models\Menu\Category;
use App\Models\Menu\Item;
use App\Services\Translators\Category\ConfigurableCategoryDataTranslator;
use App\Services\Translators\Item\ConfigurableItemDataTranslator;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use Tests\Traits\UsesXmlTestFixtures;
use Tests\Traits\UsesJsonTestFixtures;

class ConfigurableItemDataTranslatorTest extends TestCase
{
    use UsesXmlTestFixtures;
    use UsesJsonTestFixtures;

    /**
     * @param $data
     * @param $configuration
     * @dataProvider configuration_and_location_data_provider
     */
    public function test_it_can_translate_a_data_object_to_an_item_model(\stdClass $data, array $configuration)
    {
        $item = (new ConfigurableItemDataTranslator($configuration))->translate($data);

        $this->assertInstanceOf(Item::class, $item);

        $dataAsArray = json_decode(json_encode($data), true);
        foreach ($configuration['map'] as $modelAttribute => $dataAttribute) {
            if (isset($dataAttribute['transform'])) {
                $this->assertEquals($dataAttribute['transform'](Arr::get($dataAsArray, $dataAttribute['field'])), $item->$modelAttribute);
            } else {
                $this->assertEquals(Arr::get($dataAsArray, $dataAttribute['field']), $item->$modelAttribute);
            }
        }
    }

    /**
     * @dataProvider configuration_and_location_data_provider
     */
    public function test_it_throws_a_validation_exception_when_it_fails_validation($data, $configuration)
    {
        $this->expectException(ValidationException::class);
        (new ConfigurableItemDataTranslator($configuration))->translate(new \stdClass());
    }

    public function configuration_and_location_data_provider()
    {
        $this->createApplication();
        return [
            'XML Configuration' => [
                json_decode(json_encode($this->getXmlFixtureAsObject('koala-xml-grill-data')->menu->categories->category[0]->products->product[0]))->{'@attributes'},
                [
                    'map' => [
                        'name' => [
                            'field' => 'id',
                            'rules' => 'required'
                        ],
                        'description' => [
                            'field' => 'description'
                        ],
                        'active' => [
                            'field' => 'isdisabled',
                            'rules' => [\Illuminate\Validation\Rule::in(['true', 'false'])],
                            'transform' => fn ($value) => $value === 'false'
                        ]
                    ]
                ]
            ],
            'Json Configuration' => [
                (object)$this->getJsonFixtureAsObject('koala-json-eatery-menu')->objects[1],
                [
                    'map' => [
                        'name' => [
                            'field' => 'item_data.name',
                            'rules' => 'required|string',
                        ],
                        'active' => [
                            'field' => 'item_data.visibility',
                            'rules' => 'in:PUBLIC,PRIVATE',
                            'transform' => fn ($value) => $value === 'PUBLIC'
                        ]
                    ]
                ]
            ]
        ];
    }
}
