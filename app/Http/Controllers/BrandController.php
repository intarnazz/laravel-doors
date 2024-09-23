<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
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

    function patch(BrandRequest $request, Brand $brand)
    {
        $brand->update($request->validated());
        $brand->save();
        return response(
            [
                'success' => true,
                'massage' => 'Success',
                'brand' => $brand,
            ], 200
        );
    }

    function add(BrandRequest $request)
    {
        $brand = Brand::create($request->validated());
        $brand->save();

        return response([
            "success" => true,
            "message" => "Success",
            'brand' => $brand
        ]);
    }

    function delete(Request $request, Brand $brand)
    {
        if (Door::where('brand_id', $brand->id)->count() <= 0 || $request->delete === 'delete') {
            $brand->delete();
            return response(
                [
                    'success' => true,
                    'massage' => 'Success',
                ], 200
            );
        } else {
            return response(
                [
                    'success' => false,
                    'massage' => 'Unprocessable Content',
                ], 422
            );
        }
    }
}
