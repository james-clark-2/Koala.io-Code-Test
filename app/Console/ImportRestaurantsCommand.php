<?php

namespace App\Console;

use App\Services\Contracts\LocationFeedParserInterface;

class ImportRestaurantsCommand extends \Illuminate\Console\Command
{
    public function __construct(
        protected LocationFeedParserInterface $locationFeedParser
    ) {
        parent::__construct();
    }

    public function handle(): void
    {

    }
}
