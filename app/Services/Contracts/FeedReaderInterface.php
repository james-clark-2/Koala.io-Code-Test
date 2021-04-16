<?php

namespace App\Services\Contracts;

interface FeedReader
{
    public function loadAsObject(string $path): \stdClass;
    public function loadAsArray(string $path): array;
}
