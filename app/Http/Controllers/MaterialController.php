<?php

namespace App\Http\Controllers;

use App\Http\Resources\DoorResource;
use App\Http\Resources\successResource;
use App\Models\Brand;
use App\Models\Component;
use App\Models\Door;
use App\Models\Image;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    function get()
    {
        $material = Material::all();

        return response([
            'success' => true,
            'massage' => 'Success',
            'data' => $material,
        ], 200
        );
    }

    function id(Material $material)
    {
        return response(
            [
                'success' => true,
                'massage' => 'Success',
                'data' => $material,
            ], 200
        );
    }

    function patch(Request $request, Brand $material)
    {
        $material->update($request->only($material->getFillable()));
        $material->save();
        return response(
            [
                'success' => true,
                'massage' => 'Success',
                'data' => $material,
            ], 200
        );
    }
}
