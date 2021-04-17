<?php

namespace App\Services\Translators\Location;

use App\Models\Brand;
use App\Models\Location;
use App\Services\Contracts\DataTranslatorInterface;
use Illuminate\Support\Facades\Validator;

class ConfigurableLocationDataTranslator implements DataTranslatorInterface
{
    public function __construct(
        protected array $configuration
    ) { }

    public function translate(\stdClass $data): ?Location
    {
        if (!$this->valid($data)) {
            return null;
        }

        $location = new Location();

        foreach ($this->fieldMap() as $modelField => $fieldData)
        {
            $location->$modelField = $data->{$fieldData['field'] ?? $modelField};
        }

        $brandField = $this->brandIdentifier();
        $location->brand_id = Brand::findByName($data->$brandField)?->id;

        return $location;
    }

    protected function fieldMap(): array
    {
        return $this->configuration['map'] ?? [];
    }

    protected function brandIdentifier(): ?string
    {
        return $this->configuration['brand_identifier'];
    }

    protected function valid(\stdClass $data): bool
    {
        $fieldRules = collect($this->fieldMap())
            ->mapWithKeys(
                fn ($fieldConfiguration) => [$fieldConfiguration['field'] => $fieldConfiguration['rules'] ?? []]
            )->toArray();

        //Brand/business identifier is always requried
        $fieldRules[] = [$this->configuration['brand_identifier'] => 'required|string'];

        Validator::validate((array)$data, $fieldRules);

        return true;
    }
}
