<?php

namespace App\Services\Parsers;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class XmlLocationFeedParser extends FeedParser
{
    public function parse(string $path): Collection
    {
        $data = $this->feedReader->loadAsObject($path);
        $locations = new Collection();

        //@TODO: Handle multiple "restaurant" tags from XML
        //The code test data has only one restaurant as the root node, and all location data is stored as attributes of that node
        $dataObj = (object)$data->{'@attributes'};
        $location = $this->dataTranslator->translate($dataObj);

        if ($location) {
            $location = $location->firstOrNew(
                ['feed_id' => $location->feed_id],
                $location->getAttributes()
            );

            $menus = app(XmlMenuFeedParser::class)->parse($path);
            $menus->each(fn ($menu) => $location->menu()->associate($menu));
            $location->save();

            $locations->add($location);
        }

        return $locations;
    }
}
