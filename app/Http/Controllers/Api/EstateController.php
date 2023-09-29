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

        // Estrai i servizi selezionati dall'array di servizi
        $selectedServices = array_keys(array_filter($data['services'] ?? []));

        // Ottieni tutti gli Estates che soddisfano i criteri
        $estates = Estate::where('beds', '>=', $data['minBed'] ?? 0)
            ->where('rooms', '>=', $data['minRoom'] ?? 0)
            ->whereHas('services', function ($query) use ($selectedServices) {
                $query->whereIn('label', $selectedServices); // assumendo che 'name' sia la colonna con il nome del servizio
            }, '=', count($selectedServices))
            ->with('images') // includi le immagini nella risposta
            ->get();

        // Restituisci i risultati
        return response()->json([
            'results' => $estates
        ]);
    }
}
