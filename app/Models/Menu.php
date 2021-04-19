<?php

namespace App\Models;

use App\Models\Menu\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id'
    ];

    public function location(): HasOne
    {
        return $this->hasOne(Location::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
}
