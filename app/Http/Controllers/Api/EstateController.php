<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use Illuminate\Http\Request;

class EstateController extends Controller
{
    public function index()
    {
        $estates = Estate::where('is_visible', true)->orderBy('updated_at', 'DESC')->get();
        return response()->json([
            'results' => $estates
        ]);
    }
}
