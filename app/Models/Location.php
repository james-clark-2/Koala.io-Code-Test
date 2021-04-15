<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Location extends Model
{
    use HasFactory;

    public function brand(): HasOne
    {
        /**
         * Assuming each location is categorized by a single restaurant brand. In this case, both restaurants
         * are considered part of a "Koala" brand.
         * @TODO: Consider how a business case like Yum! Brands and hybrid Taco Bell+KFC+A&W+Pizza Hut locations would be represented
         */
        return $this->hasOne(Brand::class);
    }

    public function menus(): HasOne
    {
        /**
         * Assuming that each location has its own menu with mutually exclusive items
         * @TODO: Consider whether a location can have multiple menus - ex: Breakfast/Lunch/Dinner
         * @TODO: Consider whether multiple locations can share a menu (with different prices) to avoid duplicating data
         */
        return $this->hasOne(Menu::class);
    }
}
