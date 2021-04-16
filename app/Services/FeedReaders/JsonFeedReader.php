<?php

namespace App\Services;

class JsonFeedReader implements Contracts\FeedReaderInterface
{
    public function loadAsObject(string $path): \stdClass
    {
        return json_decode($this->loadJsonFile($path), true);
    }

    public function loadAsArray(string $path): array
    {
        return json_decode($this->loadJsonFile($path));
    }

    private function loadJsonFile(string $path): ?string
    {
        return file_get_contents($path);
    }
}
