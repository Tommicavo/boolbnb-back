<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\Image;
use Illuminate\Http\Request;

class EstateController extends Controller
{
    public function index()
    {
        $images = Image::all();
        $estates = Estate::where('is_visible', true)->orderBy('updated_at', 'DESC')->with('images')->get();
        return response()->json([
            'results' => $estates
        ]);
    }
}
