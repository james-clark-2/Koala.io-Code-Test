<?php

namespace App\Models\Menu;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'visible'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
