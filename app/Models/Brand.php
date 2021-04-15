<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    /**
     * @param string $name
     * @return static|null
     * @throws ModelNotFoundException
     */
    public static function findByName(string $name): ?self
    {
        return Brand::query()->firstWhere('name', '=', $name);
    }
}
