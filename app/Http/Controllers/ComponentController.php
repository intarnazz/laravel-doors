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

class ComponentController extends Controller
{
    function get()
    {
        $brand = Component::all();

        return response([
            'success' => true,
            'massage' => 'Success',
            'data' => $brand,
        ], 200
        );
    }

    function id(Component $component)
    {
        return response(
            [
                'success' => true,
                'massage' => 'Success',
                'data' => $component,
            ], 200
        );
    }

    function patch(Request $request, Brand $component)
    {
        $component->update($request->only($component->getFillable()));
        $component->save();
        return response(
            [
                'success' => true,
                'massage' => 'Success',
                'data' => $component,
            ], 200
        );
    }
}
