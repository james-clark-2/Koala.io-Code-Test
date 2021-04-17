<?php

namespace App\Services\Parsers;

use App\Services\Contracts\DataTranslatorInterface;
use App\Services\Contracts\FeedReaderInterface;
use App\Services\Contracts\LocationFeedParserInterface;
use Illuminate\Support\Collection;

class LocationFeedParser implements LocationFeedParserInterface
{
    public function __construct(
        protected FeedReaderInterface $feedReader,
        protected DataTranslatorInterface $dataTranslator
    ) { }

    public function parse(string $path): Collection
    {
        $data = $this->feedReader->loadAsObject($path);
        $locations = new Collection();

        //@TODO: Handle multiple "restaurant" tags from XML
        //The code test data has only one restaurant as the root node, and all location data is stored as attributes of that node
        $dataObj = (object)$data->{'@attributes'};
        $location = $this->dataTranslator->translate($dataObj);

        if ($location) {
            $locations->add($location);
        }

        return $locations;
    }
}
