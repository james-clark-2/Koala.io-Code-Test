<?php

namespace App\Services\Parsers;

use App\Services\Contracts\DataTranslatorInterface;
use App\Services\Contracts\FeedReaderInterface;
use App\Services\Contracts\LocationFeedParserInterface;
use Illuminate\Support\Collection;

abstract class FeedParser implements LocationFeedParserInterface
{
    public function __construct(
        protected FeedReaderInterface $feedReader,
        protected DataTranslatorInterface $dataTranslator
    ) { }

    abstract public function parse(string $path): Collection;
}
