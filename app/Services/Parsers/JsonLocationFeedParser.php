<?php

namespace App\Services\Parsers;

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

        return $locations;
    }
}
