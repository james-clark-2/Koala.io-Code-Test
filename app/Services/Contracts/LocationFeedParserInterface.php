<?php

namespace App\Services\Contracts;

use Illuminate\Support\Collection;

interface LocationFeedParserInterface
{
    public function parse(string $path): Collection;
}
