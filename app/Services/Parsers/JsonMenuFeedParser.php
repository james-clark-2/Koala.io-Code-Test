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
        $menus = new Collection();
        $menuItems = new Collection();

        foreach ($data->objects ?? [] as $dataObj) {
            if ($dataObj->type == "CATEGORY") {
                $category = $this->translateCategory($dataObj);

                if ($category) {
                    $category->menu()->associate($category);
                }
            }
        }

//        foreach ($data->objects ?? []  as $dataObj) {
//            if ($dataObj->type == "ITEM") {
//                $menuItem = $this->translateMenuItem($dataObj);
//
//                if ($menuItem) {
//                    $menuItems->add($menuItem);
//                }
//            }
//        }

        //Attach items to categories
        //Attach categories to menu

        $menus->add($menu);

        return $menus;
    }

    public function translateCategory(\stdClass $categoryData): ?Category
    {
        return app()->make(
            ConfigurableCategoryDataTranslator::class,
            [
                'configuration' => Config::get('feeds.categories.json')
            ]
        )->translate($categoryData);
    }

    public function translateMenuItem(\stdClass $itemData): ?Item
    {
        return app()->make(
            ConfigurableItemDataTranslator::class,
            [
                'configuration' => Config::get('feeds.items.json')
            ]
        )->translate($itemData);
    }
}
