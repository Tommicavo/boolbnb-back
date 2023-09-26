<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class EstateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $estate = new Estate();
        $services = Service::all();
        return view('admin.estates.create', compact('estate', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate(
            [
                'title' => 'required|string|max:50',
                'description' => 'nullable|string|max:300',
                'cover' => 'nullable|image',
                'rooms' => 'required|numeric:1,254',
                'beds' => 'required|numeric:1,254',
                'bathrooms' => 'required|numeric:1,254',
                'mq' => 'required|numeric:20,1000',
                'price' => 'required|required|numeric:0.01'
            ],
            [
                'title.required' => 'Il titole è obbligatorio.',
                'title.max' => 'Il titole deve essere lungo max 50 carattari.',
                'description.max' => 'La descrizione deve essere lunga max 300 carattari.',
                'rooms.required' => 'Il numero delle stanze è obbligatorio.',
                'rooms.required' => 'Il numero delle stanze deve essere compreso tra 1 e 254.',
                'beds.required' => 'Il numero dei letti è obbligatorio.',
                'beds.required' => 'Il numero dei letti deve essere compreso tra 1 e 254.',
                'bathrooms.required' => 'Il numero dei bagni è obbligatorio.',
                'bathrooms.required' => 'Il numero dei bagni deve essere compreso tra 1 e 254.',
                'mq.required' => 'Il numero dei mq è obbligatorio.',
                'mq.required' => 'I mq devono essere compresi tra 20 e 1000.',
                'price.required' => 'Il prezzo è obbligatorio.',
                'price.required' => 'Il prezzo deve essere compreso tra € 0.01 ed € 254.00.',
                'cover.image' => "È possibile allegare solo file di tipo immagine."
            ]
        );

        $data = $request->all();

        // Change is_visible switch value to a boolean one.
        $data['is_visible'] = isset($data['is_visible']);

        $estate = new Estate;
        $estate->fill($data);
        $estate->save();

        if (Arr::exists($data, 'services')) $estate->services()->attach($data['services']);

        return to_route('admin.estates.create', $estate)->with("type", "success")->with("message", "Annuncio inserito");
    }

    /**
     * Display the specified resource.
     */
    public function show(Estate $estate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estate $estate)
    {
        $services = Service::all();
        $estate_service_ids = $estate->services->pluck('id')->toArray();
        return view('admin.estates.edit', compact('estate', 'services', 'estate_service_ids'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estate $estate)
    {
        // Validation
        $request->validate(
            [
                'title' => 'required|string|max:50',
                'description' => 'nullable|string|max:300',
                'cover' => 'nullable|image',
                'rooms' => 'required|numeric:1,254',
                'beds' => 'required|numeric:1,254',
                'bathrooms' => 'required|numeric:1,254',
                'mq' => 'required|numeric:20,1000',
                'price' => 'required|required|numeric:0.01'
            ],
            [
                'title.required' => 'Il titole è obbligatorio.',
                'title.max' => 'Il titole deve essere lungo max 50 carattari.',
                'description.max' => 'La descrizione deve essere lunga max 300 carattari.',
                'rooms.required' => 'Il numero delle stanze è obbligatorio.',
                'rooms.required' => 'Il numero delle stanze deve essere compreso tra 1 e 254.',
                'beds.required' => 'Il numero dei letti è obbligatorio.',
                'beds.required' => 'Il numero dei letti deve essere compreso tra 1 e 254.',
                'bathrooms.required' => 'Il numero dei bagni è obbligatorio.',
                'bathrooms.required' => 'Il numero dei bagni deve essere compreso tra 1 e 254.',
                'mq.required' => 'Il numero dei mq è obbligatorio.',
                'mq.required' => 'I mq devono essere compresi tra 20 e 1000.',
                'price.required' => 'Il prezzo è obbligatorio.',
                'price.required' => 'Il prezzo deve essere compreso tra € 0.01 ed € 254.00.',
                'cover.image' => "È possibile allegare solo file di tipo immagine."
            ]
        );

        $data = $request->all();

        // Change is_visible switch value to boolean one.
        $data['is_visible'] = isset($data['is_visible']);

        $estate->update($data);

        // Attach if services exitsts
        if (!Arr::exists($data, 'services') && count($estate->services)) $estate->services()->detach();
        elseif (Arr::exists($data, 'services')) $estate->services()->sync($data['services']);

        return to_route('admin.estates.create')->with('type', 'success')->with('message', 'Annuncio modificato con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estate $estate)
    {
        //
    }
}
