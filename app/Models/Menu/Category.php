<?php

namespace App\Models\Menu;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Category
 * @package App\Models\Menu
 *
 * The Category model represents a menu category - ex: Beverages, Entrees, and contains menu items
 * @TODO: Seed a "root" category for menu items without a category
 * @TODO: Set up a pivot table so an item can belong to multiple categories - ex: A milkshake could be listed under "Beverages" and "Desserts"
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'feed_id',
        'menu_id'
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
