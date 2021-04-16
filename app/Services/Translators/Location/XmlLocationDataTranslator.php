<?php

namespace App\Services\Translators\Location;

use App\Models\Brand;
use App\Models\Location;
use App\Services\Contracts\DataTranslatorInterface;

class XmlLocationDataTranslator implements DataTranslatorInterface
{
    public function translate(\stdClass $data): ?Location
    {
        if (!$this->valid($data)) {
            return null;
        }

        $location = new Location([
            'feed_id' => $data->id,
            'name' => $data->name,
            'phone_number' => $data->telephone
        ]);

        $location->brand = Brand::findByName($data->storename);

        return $location;
    }

    protected function valid(\stdClass $data): bool
    {
        return isset(
            $data->id,
            $data->name,
            $data->telephone
        );
    }
}
