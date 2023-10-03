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
        //
    }

    public function show(string $id)
    {
        $estate = Estate::where('id', $id)->with('images')->with('services')->first();
        if (!$estate) return response(null, 404);
        return response()->json($estate);
    }

    public function filter(Request $request)
    {
        $data = $request->all();

        if (strlen($data['place']['address']) == 0) {
            $estates = Estate::where('is_visible', true)->orderBy('updated_at', 'DESC')->with('services')->with('images')->get();
            return response()->json($estates);
        } else {
            $withinRadiusEstates = [];
            $place_lat = $data['place']['lat'];
            $place_lon = $data['place']['lon'];
            $radius = $data['radius'];

            $estates = Estate::where('is_visible', true)->with('services')->with('images')->get();

            // Return an array of estates within the radius specified, sorted by distance
            $withinRadiusEstates = $this->checkDistance($place_lat, $place_lon, $radius, $estates);

            return response()->json($withinRadiusEstates);
        }
    }

    public function checkDistance($place_lat, $place_lon, $r, $estates)
    {
        $withinRadiusEstates = [];

        foreach ($estates as $estate) {
            // Convert latitude and longitude from degrees to radians
            $lat1 = deg2rad($place_lat);
            $lon1 = deg2rad($place_lon);
            $lat2 = deg2rad($estate->latitude);
            $lon2 = deg2rad($estate->longitude);

            // Haversine formula to calculate the distance
            $dLat = $lat2 - $lat1;
            $dLon = $lon2 - $lon1;
            $a = sin($dLat / 2) * sin($dLat / 2) + cos($lat1) * cos($lat2) * sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

            // Radius of the Earth in kilometers
            $earthRadius = 6371.0;

            // Calculate the distance
            $distance = $earthRadius * $c;

            // Create an array only with estates within radius
            if ($distance <= $r) {
                $estate->distance = $distance;
                $withinRadiusEstates[] = $estate;
            }
        }

        // Sort array estates by distance
        usort($withinRadiusEstates, function ($a, $b) {
            if ($a->distance == $b->distance) return 0;
            return ($a->distance > $b->distance) ? 1 : -1;
        });

        return $withinRadiusEstates;
    }
}
