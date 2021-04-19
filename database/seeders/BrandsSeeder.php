<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Brand::firstOrCreate(
            ['brand_code' => 'koala'],
            ['pretty_name' => 'Koala']
        );
    }
}
