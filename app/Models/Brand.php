<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Brand
 * @package App\Models
 *
 * This model behaves as a common brand for all locations.
 */
class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'pretty_name',
        'brand_code'
    ];

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    public function scopeBrandCode(Builder $query, string $code): Builder
    {
        return $query->where('brand_code', $code);
    }

    /**
     * @param string $name
     * @return static|null
     * @throws ModelNotFoundException
     */
    public static function findByName(string $name): ?self
    {
        //Quick and dirty caching of Brand lookups so repeated calls do not constantly hit the DB
        static $brands = [];

        return $brands[$name] ??
            ($brands[$name] = Brand::firstWhere('pretty_name', '=', $name));
    }
}
