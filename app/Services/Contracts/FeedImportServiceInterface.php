<?php

namespace App\Services;

interface FeedImportServiceInterface
{
    public function import(string $path): bool;
}
