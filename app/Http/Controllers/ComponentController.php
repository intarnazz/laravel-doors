<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComponentRequest;
use App\Models\Brand;
use App\Models\Component;
use App\Models\Component_door;
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
        if ($request->door_id) {
            $component_door = Component_door::where('component_id', $component->id)
                ->where('door_id', $request->door_id)
                ->first();
            if (!$component_door) {
                Component_door::create([
                    'door_id' => $request->door_id,
                    'component_id' => $component->id,
                ]);
            }
        }
        return response(
            [
                'success' => true,
                'massage' => 'Success',
                'data' => $component,
            ], 200
        );
    }

    function add(ComponentRequest $request)
    {
        $component = Component::create($request->validated());
        $component->save();
        if ($request->door_id) {
            $component_door = Component_door::create([
                'door_id' => $request->door_id,
                'component_id' => $component->id,
            ]);
        }
        return response([
            "success" => true,
            "message" => "Success",
            'data' => $component
        ]);
    }

    function delete(Request $request, Component $component)
    {
        if (Component_door::where('component_id', $component->id)->count() <= 0 || $request->delete === 'delete') {
            $component->delete();
            return response(
                [
                    'success' => true,
                    'massage' => 'Success',
                ], 200
            );
        } elseif ($request->door_id) {
            Component_door::where('component_id', $component->id)
                ->where('door_id', $request->door_id)
                ->delete();
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
