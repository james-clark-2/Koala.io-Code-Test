<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * Class Location
 * @package App\Models
 * @property ?Brand $brand
 * @property ?Collection $menu
 * @property int brand_id,
 * @property int feed_id
 */
class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone_number',
        'brand_id',
        'feed_id'
    ];

    public function brand(): BelongsTo
    {
        /**
         * Assuming each location is categorized by a single restaurant brand. In this case, both restaurants
         * are considered part of a "Koala" brand.
         * @TODO: Consider how a business case like Yum! Brands and hybrid Taco Bell+KFC+A&W+Pizza Hut locations would be represented
         */
        return $this->BelongsTo(Brand::class);
    }

    public function menu(): BelongsTo
    {
        /**
         * Assuming that each location has its own menu with mutually exclusive items
         * @TODO: Consider whether a location can have multiple menus - ex: Breakfast/Lunch/Dinner
         * @TODO: Consider whether multiple locations can share a menu (with different prices) to avoid duplicating data
         */
        return $this->belongsTo(Menu::class);
    }
}
