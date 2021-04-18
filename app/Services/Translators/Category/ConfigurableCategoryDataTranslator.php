<?php

namespace App\Services\Translators\Category;

use App\Models\Menu\Category;
use App\Services\Contracts\DataTranslatorInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class ConfigurableCategoryDataTranslator implements DataTranslatorInterface
{
    public function __construct(
        protected array $configuration
    ) { }

    public function translate(\stdClass $data): ?Category
    {
        if (!$this->valid($data)) {
            return null;
        }

        $category = app(Category::class);

        $dataAsArray = json_decode(json_encode($data), true);
        foreach ($this->fieldMap() as $modelField => $fieldData)
        {
            $category->$modelField = Arr::get($dataAsArray, $fieldData['field']) ?? $modelField;
        }

        return $category;
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
