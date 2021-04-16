<?php

namespace App\Services\Parsers;

use App\Services\Contracts\DataTranslatorInterface;
use App\Services\Contracts\FeedReaderInterface;
use App\Services\Contracts\LocationFeedParserInterface;
use Illuminate\Support\Collection;

class FeedParser implements LocationFeedParserInterface
{
    public function __construct(
        protected FeedReaderInterface $feedReader,
        protected DataTranslatorInterface $dataTranslator
    ) { }

    public function parse(string $path): Collection
    {
        /** @var \stdClass $data */
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
