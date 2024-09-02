<?php

namespace App\Http\Controllers;

use App\Http\Resources\DoorResource;
use App\Http\Resources\successResource;
use App\Models\Brand;
use App\Models\Door;
use App\Models\Image;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    function get()
    {
        $brand = Brand::all();

        return response([
            'success' => true,
            'massage' => 'Success',
            'data' => $brand,
        ], 200
        );
    }

    function id(Brand $brand)
    {
        return response(
            [
                'success' => true,
                'massage' => 'Success',
                'data' => $brand,
            ], 200
        );
    }

    function patch(Request $request, Brand $brand)
    {
        $brand->update($request->only($brand->getFillable()));
        $brand->save();
        return response(
            [
                'success' => true,
                'massage' => 'Success',
                'data' => $brand,
            ], 200
        );
    }
}
