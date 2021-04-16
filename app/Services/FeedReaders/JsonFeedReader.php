<?php

namespace App\Services\FeedReaders;

use App\Services\Contracts\FeedReaderInterface;

class JsonFeedReader implements FeedReaderInterface
{
    /**
     * @param string $path
     * @return \stdClass
     * @throws \ErrorException
     */
    public function loadAsObject(string $path): \stdClass
    {
        return json_decode($this->loadJsonFile($path)) ?? throw new \ErrorException();
    }

    /**
     * @param string $path
     * @return array
     * @throws \ErrorException
     */
    public function loadAsArray(string $path): array
    {
        return json_decode($this->loadJsonFile($path), true) ?? throw new \ErrorException();
    }

    /**
     * @param string $path
     * @return string|null
     */
    private function loadJsonFile(string $path): ?string
    {
        return file_get_contents($path);
    }
}
