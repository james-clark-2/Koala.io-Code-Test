<?php

namespace App\Services\Parsers;

use App\Models\Menu;
use App\Models\Menu\Category;
use App\Models\Menu\Item;
use App\Services\Translators\Category\ConfigurableCategoryDataTranslator;
use App\Services\Translators\Item\ConfigurableItemDataTranslator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class JsonMenuFeedParser extends FeedParser
{
    public function parse(string $path): Collection
    {
        $data = $this->feedReader->loadAsObject($path);

        /** @var Menu $menu */
        $menu = app(Menu::class);
        $menu->save();

        //Build out all categories first
        $this->processCategoriesForMenu($menu, $data->objects ?? []);

        //Build out all menu items and attach them to categories
        $this->processItemsForMenu($menu, $data->objects ?? []);

        return new Collection([$menu]);
    }

    protected function translateCategory(\stdClass $categoryData): ?Category
    {
        return app()->make(
            ConfigurableCategoryDataTranslator::class,
            [
                'configuration' => Config::get('feeds.categories.json')
            ]
        )->translate($categoryData);
    }

    protected function translateMenuItem(\stdClass $itemData): ?Item
    {
        return app()->make(
            ConfigurableItemDataTranslator::class,
            [
                'configuration' => Config::get('feeds.items.json')
            ]
        )->translate($itemData);
    }

    protected function processCategoriesForMenu(Menu $menu, array $dataObjects): void
    {
        foreach ($dataObjects ?? [] as $dataObj) {
            if ($dataObj->type == "CATEGORY") {
                $category = $this->translateCategory($dataObj);

                if ($category) {
                    $category = $category->firstOrNew(
                        ['feed_id' => $category->feed_id],
                        $category->getAttributes()
                    );
                    $category->menu()->associate($menu);
                    $category->save();
                }
            }
        }
    }

    protected function processItemsForMenu(Menu $menu, array $dataObjects): void
    {
        foreach ($dataObjects as $dataObj) {
            if ($dataObj->type == "ITEM") {
                $menuItem = $this->translateMenuItem($dataObj);

                if ($menuItem) {
                    $menuItem = $menuItem->firstOrNew(
                        ['feed_id' => $menuItem->feed_id],
                        $menuItem->getAttributes()
                    );

                    $menu->categories()
                        ->firstWhere('feed_id', $menuItem->category_feed_id)
                        ?->items()->save($menuItem);
                }
            }
        }
    }
}
