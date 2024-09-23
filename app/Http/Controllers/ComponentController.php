<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComponentRequest;
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

    function patch(ComponentRequest $request, Component $component)
    {
        $component->update($request->validated());
        $component->save();
        return response(
            [
                'success' => true,
                'massage' => 'Success',
                'component' => $component,
            ], 200
        );
    }

    function add(ComponentRequest $request)
    {
        $component = Material::create($request->validated());
        $component->save();

        return response([
            "success" => true,
            "message" => "Success",
            'component' => $component
        ]);
    }

    function delete(Request $request, Component $material)
    {
        if (Door::where('brand_id', $material->id)->count() <= 0 || $request->delete === 'delete') {
            $material->delete();
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
