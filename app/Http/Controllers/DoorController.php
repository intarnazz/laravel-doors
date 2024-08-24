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

class DoorController extends Controller
{
    function get(Request $request)
    {
        $ids = $request->header('ids', '');
        $count = Door::count();
        $idsArray = $ids ? explode(',', $ids) : range(1, $count);
        $skip = $request->header('skip', 0);
        $take = $request->header('take', 6);

        $doors = Door::with(['image_front', 'image_back', 'brand', 'material'])
            ->whereIn('id', $idsArray)
            ->skip($skip)
            ->take($take)
            ->get();

        return response([
            'success' => true,
            'massage' => 'Success',
            'data' => $doors,
            "pagingInfo" => [
                "limit" => $skip + $take,
                "offset" => +$skip,
                "totalCount" => count($idsArray),]], 200
        );
    }

    function id(Door $door)
    {
        $door->load('image_front', 'image_back', 'brand', 'material');
        return response(
            [
                'success' => true,
                'massage' => 'Success',
                'data' => $door,
            ], 200
        );
    }

    function getFilters()
    {
        $res = [];
        $res['brand'] = Brand::all();
        $res['material'] = Material::all();

        return response([
            'success' => true,
            'massage' => 'Success',
            'data' => $res,
        ], 200
        );
    }
}
