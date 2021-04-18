<?php

namespace App\Services\Translators\Item;

use App\Models\Menu\Item;
use App\Services\Contracts\DataTranslatorInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class ConfigurableItemDataTranslator implements DataTranslatorInterface
{
    public function __construct(
        protected array $configuration
    ) { }

    public function translate(\stdClass $data): ?Item
    {
        if (!$this->valid($data)) {
            return null;
        }

        $item = app(Item::class);

        $dataAsArray = json_decode(json_encode($data), true);
        foreach ($this->fieldMap() as $modelField => $fieldData)
        {
            $value = Arr::get($dataAsArray, $fieldData['field']);

            if (isset($fieldData['transform'])) {
                $value = $fieldData['transform']($value);
            }

            $item->$modelField = $value;
        }

        return $item;
    }

    protected function fieldMap(): array
    {
        return $this->configuration['map'] ?? [];
    }

    protected function valid(\stdClass $data): bool
    {
        $fieldRules = collect($this->fieldMap())
            ->mapWithKeys(
                fn ($fieldConfiguration) => [$fieldConfiguration['field'] => $fieldConfiguration['rules'] ?? []]
            )->toArray();

        //Quick and dirty way to transform nested stdClass into a nested array
        Validator::validate(json_decode(json_encode($data), true), $fieldRules);

        return true;
    }
}
