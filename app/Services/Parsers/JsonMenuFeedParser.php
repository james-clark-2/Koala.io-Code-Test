<?php

namespace App\Services\Parsers;

use App\Models\Category;
use App\Models\Location;
use App\Models\Menu\Item;

class JsonMenuFeedParser implements \App\Services\Contracts\LocationFeedParserInterface
{
    public function parse(string $path): array
    {
        /** @var \stdClass $data */
        $data = json_decode($this->loadJsonFile($path));
        $locations = [];

        foreach ($data->objects ?? [] as $dataObj) {
            //Category

            //Item
        }

        return $locations;
    }

    private function loadJsonFile(string $path): ?string
    {
        return file_get_contents($path);
    }

    private function parseItem(\stdClass $item): Item
    {
        return new Item;
    }

    private function parseCategory(\stdClass $category): Category
    {
        return new Category();
    }
}
