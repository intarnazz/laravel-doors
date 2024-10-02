<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialRequest;
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

    function patch(MaterialRequest $request, Material $material)
    {
        $material->update($request->validated());
        $material->save();
        return response(
            [
                'success' => true,
                'massage' => 'Success',
                'data' => $material,
            ], 200
        );
    }

    function add(MaterialRequest $request)
    {
        $material = Material::create($request->validated());
        $material->save();

        return response([
            "success" => true,
            "message" => "Success",
            'data' => $material
        ]);
    }

    function delete(Request $request, Material $material)
    {
        if (Door::where('material_id', $material->id)->count() <= 0 || $request->delete === 'delete') {
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


