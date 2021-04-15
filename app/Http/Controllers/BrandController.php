<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BrandController extends Controller
{
    public function brand(string $brand_code)
    {
        return Brand::brandCode()->firstOrFail();
    }

    public function locations(Request $request, string $brandCode)
    {
        $request->validate([
           'page' => 'int|gt:0',
           'perPage' => 'int|gt:0'
        ]);

        return Brand::brandCode($brandCode)
            ->firstOrFail()
            ->locations()
            ->paginate(
                $request->get('page', 1),
                $request->get('perPage', 25)
            );
    }

    public function location(string $brandCode, string $id)
    {
        return Brand::brandCode($brandCode)->locations()->findOrFail($id);
    }

    public function menu(string $brandCode, string $locationId, string $menuId)
    {
        return response('NYI', 404);
    }
}
