<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Item
 * @package App\Models\Menu
 *
 * @property string category_feed_id
 *
 * The Item model represents a product on the menu
 * @TODO: Set up a pivot table so an item can belong to multiple categories - ex: A milkshake could be listed under "Beverages" and "Desserts"
 */
class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'visible',
        'feed_id',
        'category_feed_id'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
