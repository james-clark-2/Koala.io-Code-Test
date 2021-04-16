<?php

namespace Tests\Traits;

use Illuminate\Support\Str;

trait GetsXmlTestFixtures
{
    public function getXmlFixture(string $path): \SimpleXMLElement
    {
        if (!Str::endsWith($path, '.xml')) {
            $path .= '.xml';
        }

        return simplexml_load_file(base_path('tests/Fixtures/'.ltrim($path, '/')));
    }

    public function getXmlFixtureAsArray(string $path): ?array
    {
        return (array)$this->getXmlFixture($path);
    }

    public function getXmlFixtureAsObject(string $path): ?\stdClass
    {
        return (object)$this->getXmlFixtureAsArray($path);
    }
}
