<?php

namespace Services;

use App\Services\FeedReaders\JsonFeedReader;
use Tests\TestCase;

class JsonFeedReaderTest extends TestCase
{
    public function test_it_can_read_a_json_file_into_an_array()
    {
        $result = (new JsonFeedReader())->loadAsArray(base_path('tests/Fixtures/koala-json-eatery-location.json'));

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }

    public function test_it_can_read_a_json_file_into_an_object()
    {
        $result = (new JsonFeedReader())->loadAsObject(base_path('tests/Fixtures/koala-json-eatery-location.json'));

        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertNotEmpty($result);
    }

    /**
     * @dataProvider loader_function_name_provider
     */
    public function test_it_throws_an_exception_for_invalid_json($functionName)
    {
        $this->expectException(\ErrorException::class);
        (new JsonFeedReader())->$functionName(base_path('tests/Fixtures/invalid-json.json'));
    }

    public function loader_function_name_provider()
    {
        return [
            'loadAsArray' => ['loadAsArray'],
            'loadAsObject' => ['loadAsObject']
        ];
    }
}
