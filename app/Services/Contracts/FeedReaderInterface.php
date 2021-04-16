<?php

namespace App\Services\Contracts;

interface FeedReaderInterface
{
    public function loadAsObject(string $path): \stdClass;
    public function loadAsArray(string $path): array;
}
