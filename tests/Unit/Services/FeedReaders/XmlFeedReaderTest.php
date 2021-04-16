<?php

namespace Services;

use App\Services\FeedReaders\XmlFeedReader;
use Tests\TestCase;

class XmlFeedReaderTest extends TestCase
{
    public function test_it_can_read_a_xml_file_into_an_array()
    {
        $result = (new XmlFeedReader())->loadAsArray(base_path('/tests/Fixtures/koala-xml-grill-data.xml'));

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }

    public function test_it_can_read_a_xml_file_into_an_object()
    {
        $result = (new XmlFeedReader())->loadAsObject(base_path('/tests/Fixtures/koala-xml-grill-data.xml'));

        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertNotEmpty($result);
    }

    /**
     * @dataProvider loader_function_name_provider
     */
    public function test_it_throws_an_exception_for_invalid_xml($functionName)
    {
        $this->expectException(\ErrorException::class);
        (new XmlFeedReader())->$functionName(base_path('/tests/Fixtures/invalid-xml.xml'));
    }

    public function loader_function_name_provider()
    {
        return [
            'loadAsArray' => ['loadAsArray'],
            'loadAsObject' => ['loadAsObject']
        ];
    }
}
