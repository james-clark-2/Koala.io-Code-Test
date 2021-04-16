<?php

namespace App\Services\Translators\Location;

use App\Models\Brand;
use App\Models\Location;
use App\Services\Contracts\DataTranslatorInterface;

class JsonLocationDataTranslator implements DataTranslatorInterface
{
    public function translate(\stdClass $locationData): ?Location
    {
        $location = new Location([
            'feed_id' => $locationData->id,
            'name' => $locationData->name,
            'description' => $locationData->description,
            'phone_number' => $locationData->phone_number
        ]);

        $location->brand = Brand::findByName($locationData->business_name);

        return $location;
    }
}
