<?php

namespace App\Services\FeedReaders;

use App\Services\Contracts\FeedReaderInterface;

class XmlFeedReader implements FeedReaderInterface
{
    public function loadAsObject(string $path): \stdClass
    {
        return (object)$this->loadAsArray($path);
    }

    public function loadAsArray(string $path): array
    {
        return (array)$this->loadXmlFile($path);
    }

    private function loadXmlFile(string $path): \SimpleXMLElement
    {
        return simplexml_load_file($path);
    }
}
