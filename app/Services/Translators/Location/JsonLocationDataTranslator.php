<?php

namespace App\Services\Translators\Location;

use App\Models\Brand;
use App\Models\Location;
use App\Services\Contracts\DataTranslatorInterface;

class JsonLocationDataTranslator implements DataTranslatorInterface
{
    public function translate(\stdClass $data): ?Location
    {
        if (!$this->valid($data)) {
            return null;
        }

        $location = new Location([
            'feed_id' => $data->id,
            'name' => $data->name,
            'description' => $data->description ?? null,
            'phone_number' => $data->phone_number
        ]);

        $location->brand = Brand::findByName($data->business_name);

        return $location;
    }

    protected function valid(\stdClass $data): bool
    {
        return isset(
            $data->id,
            $data->name,
            $data->phone_number
        );
    }
}
