<?php

namespace App\Services\Parsers;

use App\Models\Brand;
use App\Models\Location;
use App\Services\Contracts\LocationFeedParserInterface;
use Illuminate\Support\Collection;

class JsonLocationFeedParser implements LocationFeedParserInterface
{
    public function __construct(
        protected string $path
    ) { }

    public function parse(string $path): Collection
    {
        /** @var \stdClass $data */
        $data = json_decode($this->loadJsonFile($path));
        $locations = new Collection();

        foreach ($data->locations ?? [] as $dataObj) {
            $location = new Location([
                'name' => $dataObj->name,
                'description' => $dataObj->description,
                'timezone' => $dataObj->timezone ?? \DateTimeZone::UTC,
                'phone_number' => $dataObj->phone_number,
                'active' => $dataObj->status === 'ACTIVE'
            ]);

            $location->brand = Brand::findByName($dataObj->business_name);

            $locations->add($location);
        }

        return $locations;
    }

    private function loadJsonFile(string $path): ?string
    {
        return file_get_contents($path);
    }
}
