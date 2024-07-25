<?php

namespace App\Http\Controllers;

use App\Models\Door;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DoorController extends Controller
{
    function get()
    {
        return response(
            Door::all()
        );
    }

    function id(Door $door)
    {
        return response(
            $door
        );
    }
}
