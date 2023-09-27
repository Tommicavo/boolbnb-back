<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Estate;
use App\Models\Image;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class EstateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estates = Estate::orderBy('updated_at', 'DESC')->get();
        return view('admin.estates.index', compact('estates'));
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
                'cover' => 'nullable',
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
                'cover.image' => "È possibile allegare solo file di tipo immagine."
            ]
        );

        $data = $request->all();
        $images = $request->file('multiple_images');

        // Change is_visible switch value to a boolean one.
        $data['is_visible'] = isset($data['is_visible']);

        $estate = new Estate;
        $estate->fill($data);
        $estate->cover = $images[0] ?? 'https://marcolanci.it/utils/placeholder.jpg';
        $estate->save();



        // ############# ADDRESS #############
        // Push address into DB
        $address = new Address();
        $address->fill($data);

        $query = '';

        foreach ($address->toArray() as $field) {
            $query .= $field . '%20';
        };
        $response = Http::get("https://api.tomtom.com/search/2/geocode/$query.json?storeResult=false&lat=37.337&lon=-121.89&view=Unified&key=M67vYPGoqcGCwsgAOqnQFq8m8VRJHYoW");

        $jsonData = $response->json();

        $address->latitude = $jsonData['results'][0]['position']['lat'];
        $address->longitude = $jsonData['results'][0]['position']['lon'];
        $address->estate_id = $estate->id;

        $address->save();



        // ############# IMAGES #############
        // Save multiple images
        if ($images) {
            foreach ($images as $image) {
                $img_path = Storage::putFile("estate_images/$estate->id", $image);
                $new_image = new Image();
                $new_image->url = $img_path;
                $new_image->estate_id = $estate->id;
                $new_image->save();
            };
        }

        if (Arr::exists($data, 'services')) $estate->services()->attach($data['services']);

        return to_route('admin.estates.create', $estate, $address)->with("type", "success")->with("message", "Annuncio inserito");
    }

    /**
     * Display the specified resource.
     */
    public function show(Estate $estate)
    {
        return view('admin.estates.show', compact('estate'));
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
    public function update(Request $request, string $id)
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
                'cover.image' => "È possibile allegare solo file di tipo immagine."
            ]
        );

        $data = $request->all();

        // Change is_visible switch value to boolean one.
        $data['is_visible'] = isset($data['is_visible']);

        $estate = Estate::findOrFail($id);
        $estate->update($data);

        // Delete multiple images before update
        Storage::deleteDirectory("estate_images/$estate->id");

        foreach ($estate->images as $image) {
            $image->delete();
        };

        $images = $request->file('multiple_images');

        // Save multiple images
        if ($images) {
            foreach ($images as $image) {
                $img_path = Storage::putFile("estate_images/$estate->id", $image);
                $new_image = new Image();
                $new_image->url = $img_path;
                $new_image->estate_id = $estate->id;
                $new_image->save();
            };
        }

        // Attach if services exitsts
        if (!Arr::exists($data, 'services') && count($estate->services)) $estate->services()->detach();
        elseif (Arr::exists($data, 'services')) $estate->services()->sync($data['services']);

        return to_route('admin.estates.create')->with('type', 'success')->with('message', 'Annuncio modificato con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $estate = Estate::findOrFail($id);
        $estate->delete();

        return to_route('admin.estates.index')
            ->with('alertType', 'info')
            ->with('alertTitle', "$estate->title")
            ->with('alertMessage', 'has been moved into Trash Can!');
    }

    public function trash()
    {
        $estates = Estate::onlyTrashed()->get();

        return view('admin.estates.trash', compact('estates'));
    }

    public function drop(string $id)
    {
        $estate = Estate::onlyTrashed()->findOrFail($id);

        // ! DA VERIFICARE CHE LA COVER E LE IMMAGINI SI CANCELLINO !
        if ($estate->cover) Storage::delete($estate->cover);
        if ($estate->images) {
            foreach ($estate->images as $image) Storage::delete($image);
        }

        if (count($estate->services)) $estate->services()->detach();
        if (count($estate->sponsorships)) $estate->sponsorships()->detach();

        $estate->forceDelete();

        return to_route('admin.estates.trash')
            ->with('alertType', 'danger')
            ->with('alertTitle', "$estate->title")
            ->with('alertMessage', 'has been successfully erased from Trash Can!');
    }

    public function dropAll()
    {
        $estates = Estate::onlyTrashed()->get();
        $estates_count = Estate::onlyTrashed()->count();

        foreach ($estates as $estate) {
            // ! DA VERIFICARE CHE LA COVER E LE IMMAGINI SI CANCELLINO !
            if ($estate->cover) Storage::delete($estate->cover);
            if ($estate->images) {
                foreach ($estate->images as $image) Storage::delete($image);
            }

            if (count($estate->services)) $estate->services()->detach();
            if (count($estate->sponsorships)) $estate->sponsorships()->detach();

            $estate->forceDelete();
        }

        return to_route('admin.estates.index')
            ->with('alertType', 'danger')
            ->with('alertMessage', "$estates_count estates have been successfully erased from Trash Can!");
    }

    public function restore(string $id)
    {
        $estate = Estate::onlyTrashed()->findOrFail($id);

        $estate->restore();

        return to_route('admin.estates.trash')
            ->with('alertType', 'success')
            ->with('alertTitle', "$estate->title")
            ->with('alertMessage', 'has been successfully restored!');
    }

    public function restoreAll()
    {
        $estates = Estate::onlyTrashed();
        $estates_count = Estate::onlyTrashed()->count();

        $estates->restore();

        return to_route('admin.estates.index')
            ->with('alertType', 'success')
            ->with('alertMessage', "$estates_count estates have been successfully restored!");
    }
}
