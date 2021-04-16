<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;

interface DataTranslatorInterface
{
    public function translate(\stdClass $data): ?Model;
}
