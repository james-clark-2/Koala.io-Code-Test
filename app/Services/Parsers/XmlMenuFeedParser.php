<?php

namespace App\Services\Parsers;

use App\Models\Menu;
use App\Models\Menu\Category;
use App\Models\Menu\Item;
use App\Services\Translators\Category\ConfigurableCategoryDataTranslator;
use App\Services\Translators\Item\ConfigurableItemDataTranslator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class XmlMenuFeedParser extends FeedParser
{
    public function parse(string $path): Collection
    {
        $data = $this->feedReader->loadAsObject($path);

        /** @var Menu $menu */
        $menu = app(Menu::class);
        $menu->save();

        $dataObjects = json_decode(json_encode($data->menu->categories))->category;

        //Categories and products are nested for XML docs, so we can handle both sets at once
        foreach ($dataObjects as $categoryAndProductsData) {
            $this->processCategoryAndProductsForMenu($menu, $categoryAndProductsData);
        }

        return new Collection([$menu]);
    }

    protected function translateCategory(\stdClass $categoryData): ?Category
    {
        return app()->make(
            ConfigurableCategoryDataTranslator::class,
            [
                'configuration' => Config::get('feeds.categories.xml')
            ]
        )->translate($categoryData);
    }

    protected function translateMenuItem(\stdClass $itemData): ?Item
    {
        return app()->make(
            ConfigurableItemDataTranslator::class,
            [
                'configuration' => Config::get('feeds.items.xml')
            ]
        )->translate($itemData);
    }

    protected function processCategoryAndProductsForMenu(Menu $menu, \stdClass $categoryAndProductsDataObject): void
    {
        $category = $this->processCategoryDataForMenu($menu, $categoryAndProductsDataObject->{'@attributes'});
        $this->processItemsForCategory($category, $categoryAndProductsDataObject->products);
    }

    protected function processCategoryDataForMenu(Menu $menu, \stdClass $categoryDataObject): ?Category
    {
        $category = $this->translateCategory($categoryDataObject);

        if ($category) {
            $category = $category->firstOrNew(
                ['feed_id' => $category->feed_id],
                $category->getAttributes()
            );
            $category->menu()->associate($menu);
            $category->save();
        }

        return $category;
    }

    protected function processItemsForCategory(Category $category, \stdClass $itemDataObjects): void
    {
        //Workaround for XML parsing. The product attribute will be a stdClass for a single item, and an array for multiple
        $itemDataObjects = Arr::wrap($itemDataObjects->product);

        foreach ($itemDataObjects as $dataObj) {
            $menuItem = $this->translateMenuItem($dataObj->{'@attributes'});

            if ($menuItem) {
                $menuItem = $menuItem->firstOrNew(
                    ['feed_id' => $menuItem->feed_id],
                    $menuItem->getAttributes()
                );

                $category->items()->save($menuItem);
            }
        }
    }
}
