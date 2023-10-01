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
        $estates = Estate::where('is_visible', true)->orderBy('updated_at', 'DESC')->with('images')->get();
        return response()->json([
            'results' => $estates
        ]);
    }

    public function filterByTitle($query)
    {
        $estates = Estate::where('title', 'like', '%' . $query . '%')->with('images')->get();

        return response()->json(['results' => $estates]);
    }

    public function show(string $id)
    {
        $estate = Estate::where('id', $id)->with('images')->first();
        return response()->json($estate);
    }

    public function filter(Request $request)
    {
        $data = $request->all();

        $withinRadiusEstates = [];

        $place_lat = $data['place']['lat'];
        $place_lon = $data['place']['lon'];
        $radius = $data['radius'];
        $selectedServices = array_keys(array_filter($data['services'] ?? [])); // Get keys from truty item of services array

        // Get estates with minimum number of beds and rooms, and indicated services
        $estates = Estate::where('beds', '>=', $data['minBeds'] ?? 0)
            ->where('rooms', '>=', $data['minRooms'] ?? 0)
            ->whereHas('services', function ($query) use ($selectedServices) {
                $query->whereIn('label', $selectedServices);
            }, '=', count($selectedServices))
            ->with('services')->get();

        // Return an array of estates within the radius specified, sorted by distance
        $withinRadiusEstates = $this->checkDistance($place_lat, $place_lon, $radius, $estates);

        $output = compact('data', 'withinRadiusEstates');
        return response()->json($output);
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
