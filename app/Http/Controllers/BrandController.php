<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BrandController extends Controller
{
    public function brand(string $brandCode)
    {
        return Brand::brandCode($brandCode)->firstOrFail();
    }

    public function locations(Request $request, string $brandCode)
    {
        $request->validate([
           'page' => 'int|gt:0',
           'per_page' => 'int|gt:0'
        ]);

        return Brand::brandCode($brandCode)
            ->firstOrFail()
            ->locations()
            ->paginate(
                $request->get('per_page', 25),
                $request->get('page', 1)
            );
    }

    public function location(string $brandCode, string $id)
    {
        return Brand::brandCode($brandCode)->locations()->firstOrFail(['feed_id' => $id]);
    }

    public function menu(string $brandCode, string $locationId)
    {
        return Brand::brandCode($brandCode)->locations()->firstOrFail(['feed_id' => $locationId])->menu;
    }
}
