<?php

namespace App\Services\Parsers;

use App\Models\Location;
use Illuminate\Support\Collection;

class JsonLocationFeedParser extends FeedParser
{
    public function parse(string $path): Collection
    {
        $data = $this->feedReader->loadAsObject($path);
        $locations = new Collection();

        foreach ($data->locations ?? [] as $dataObj) {
            $location = $this->dataTranslator->translate($dataObj);

            if ($location) {
                $locations->add($location);
            }
        }

        return $this->saveLocations($locations);
    }

    protected function saveLocations(Collection $locations): Collection
    {
        return $locations->each(
            fn (Location $location) =>
                $location->updateOrCreate(
                    ['feed_id' => $location->feed_id],
                    $location->getAttributes()
                )
        );
    }
}
