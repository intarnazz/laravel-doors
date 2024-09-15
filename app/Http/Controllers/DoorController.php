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
        $response_id = $request->header('responseId', 1);
        $brand = $request->header('brand', '');
        $material = $request->header('material', '');
        $brandArr = $brand ? explode(',', $brand) : range(1, Brand::count());
        $materialArr = $material ? explode(',', $material) : range(1, Material::count());
        $doors = Door::with(['image_front', 'image_back', 'brand', 'material', 'components'])
            ->whereIn('id', $idsArray)
            ->whereIn('brand_id', $brandArr)
            ->whereIn('material_id', $materialArr)
            ->skip($skip)
            ->take($take)
            ->get();

        return response([
            'success' => true,
            'massage' => 'Success',
            'data' => $doors,
            'response_id' => $response_id,
            "pagingInfo" => [
                "limit" => $skip + $take,
                "offset" => +$skip,
                "totalCount" => count($idsArray),]], 200
        );
    }

    function id(Door $door)
    {
        $door->full();
        return response(
            [
                'success' => true,
                'massage' => 'Success',
                'data' => $door,
            ], 200
        );
    }

    function patch(Request $request, Door $door)
    {
        $door->update($request->only($door->getFillable()));
        $door->save();
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
