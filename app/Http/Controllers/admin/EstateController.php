<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Estate;
use App\Models\Image;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
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
                // Estate validation
                'title' => 'required|string|max:50',
                'description' => 'nullable|string|max:300',
                'rooms' => 'required|numeric:1,254',
                'beds' => 'required|numeric:1,254',
                'bathrooms' => 'required|numeric:1,254',
                'mq' => 'required|numeric:20,1000',
                'price' => 'required|numeric:0.01',

                // Address validation
                'toponymic' => 'required|string|max:15',
                'street_name' => 'required|string|max:50',
                'number' => 'required|numeric:1,500',
                'zip_code' => 'required|numeric:10000,99999',
                'city' => 'required|string|max:50',

                // File validation
                'multiple_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ],
            [
                // Estate errors bag
                'title.required' => 'Il titole è obbligatorio.',
                'title.max' => 'Il titole deve essere lungo max 50 carattari.',
                'description.max' => 'La descrizione deve essere lunga max 300 carattari.',
                'rooms.required' => 'Il numero delle stanze è obbligatorio.',
                'rooms.numeric' => 'Il numero delle stanze deve essere compreso tra 1 e 254.',
                'beds.required' => 'Il numero dei letti è obbligatorio.',
                'beds.numeric' => 'Il numero dei letti deve essere compreso tra 1 e 254.',
                'bathrooms.required' => 'Il numero dei bagni è obbligatorio.',
                'bathrooms.numeric' => 'Il numero dei bagni deve essere compreso tra 1 e 254.',
                'mq.required' => 'Il numero dei mq è obbligatorio.',
                'mq.numeric' => 'I mq devono essere compresi tra 20 e 1000.',

                // Address errors bag
                'toponymic.required' => 'La particella è obbligatoria.',
                'toponymic.max' => 'La particella deve essere lunga max 15 carattari.',
                'street_name.required' => 'Il nome della via è obbligatorio.',
                'street_name.max' => 'Il nome della via deve essere lunga max 50 carattari.',
                'number.required' => 'Il numero civico è obbligatorio.',
                'number.numeric' => 'Il numero civico deve essere compreso tra 1 e 500.',
                'zip_code.required' => 'Il CAP è obbligatorio.',
                'zip_code.numeric' => 'Il CAP deve essere un numero.',
                'city.required' => 'La città è obbligatoria.',
                'city.max' => 'La città deve essere lunga max 50 carattari.',

                // Images errors bag
                'multiple_images.required' => "È richiesta almeno un'immagine.",
                'multiple_images.image' => 'Le immagini devono essere di tipo jpeg,png,jpg,gif.',
                'multiple_images.mimes' => 'Le immagini devono essere di tipo jpeg,png,jpg,gif.',
                'multiple_images.max' => 'I file devono pesare max 2Mb.'
            ]
        );
        $data = $request->all();

        // ############# ADDRESS #############
        // Push address into DB
        $api_key = 'M67vYPGoqcGCwsgAOqnQFq8m8VRJHYoW';
        $address = new Address();
        $address->fill($data);

        $address_data = $address->toArray();
        $query = $this->get_query($address_data);

        $response = Http::get("https://api.tomtom.com/search/2/geocode/$query.json?&key=$api_key");

        $jsonData = $response->json();

        if (!count($jsonData['results'])) {

            return to_route('admin.estates.create')->with('alertType', 'danger')->with('alertMessage', 'Indirizzo è inesistente');
        }

        $images = $request->file('multiple_images');

        // Change is_visible switch value to a boolean one.
        $data['is_visible'] = isset($data['is_visible']);

        $estate = new Estate;
        $estate->fill($data);
        $estate->user_id = Auth::user()->id;
        $estate->save();

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

        return to_route('admin.estates.show', $estate->id)->with("alertType", "success")->with("message", "Annuncio inserito")->with('alertTitle', "$estate->title");
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
                // Estate validation
                'title' => 'required|string|max:50',
                'description' => 'nullable|string|max:300',
                'rooms' => 'required|numeric:1,254',
                'beds' => 'required|numeric:1,254',
                'bathrooms' => 'required|numeric:1,254',
                'mq' => 'required|numeric:20,1000',
                'price' => 'required|numeric:0.01',

                // Address validation
                'toponymic' => 'required|string|max:15',
                'street_name' => 'required|string|max:50',
                'number' => 'required|numeric:1,500',
                'zip_code' => 'required|numeric:10000,99999',
                'city' => 'required|string|max:50',

                // File validation
                'multiple_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ],
            [
                // Estate errors bag
                'title.required' => 'Il titole è obbligatorio.',
                'title.max' => 'Il titole deve essere lungo max 50 carattari.',
                'description.max' => 'La descrizione deve essere lunga max 300 carattari.',
                'rooms.required' => 'Il numero delle stanze è obbligatorio.',
                'rooms.numeric' => 'Il numero delle stanze deve essere compreso tra 1 e 254.',
                'beds.required' => 'Il numero dei letti è obbligatorio.',
                'beds.numeric' => 'Il numero dei letti deve essere compreso tra 1 e 254.',
                'bathrooms.required' => 'Il numero dei bagni è obbligatorio.',
                'bathrooms.numeric' => 'Il numero dei bagni deve essere compreso tra 1 e 254.',
                'mq.required' => 'Il numero dei mq è obbligatorio.',
                'mq.numeric' => 'I mq devono essere compresi tra 20 e 1000.',

                // Address errors bag
                'toponymic.required' => 'La particella è obbligatoria.',
                'toponymic.max' => 'La particella deve essere lunga max 15 carattari.',
                'street_name.required' => 'Il nome della via è obbligatorio.',
                'street_name.max' => 'Il nome della via deve essere lunga max 50 carattari.',
                'number.required' => 'Il numero civico è obbligatorio.',
                'number.numeric' => 'Il numero civico deve essere compreso tra 1 e 500.',
                'zip_code.required' => 'Il CAP è obbligatorio.',
                'zip_code.numeric' => 'Il CAP deve essere un numero.',
                'city.required' => 'La città è obbligatoria.',
                'city.max' => 'La città deve essere lunga max 50 carattari.',

                // Images errors bag
                'multiple_images.required' => "È richiesta almeno un'immagine.",
                'multiple_images.image' => 'Le immagini devono essere di tipo jpeg,png,jpg,gif.',
                'multiple_images.mimes' => 'Le immagini devono essere di tipo jpeg,png,jpg,gif.',
                'multiple_images.max' => 'I file devono pesare max 2Mb.'
            ]
        );

        $data = $request->all();

        $estate = Estate::findOrFail($id);

        // ############# ADDRESS #############
        // Update address into DB
        $api_key = 'M67vYPGoqcGCwsgAOqnQFq8m8VRJHYoW';
        $temp_address = new Address();
        $temp_address->fill($data);

        $address_data = $temp_address->toArray();
        $query = $this->get_query($address_data);

        $response = Http::get("https://api.tomtom.com/search/2/geocode/$query.json?&key=$api_key");

        $jsonData = $response->json();

        if (!count($jsonData['results'])) {

            return  to_route('admin.estates.edit', $estate->id)->with('alertType', 'danger')->with('alertMessage', 'Indirizzo è inesistente')->with('alertTitle', "$estate->title");
        }

        // Change is_visible switch value to boolean one.
        $data['is_visible'] = isset($data['is_visible']);

        $estate->update($data);
        $estate->address->update($data);



        $estate->address->latitude = $jsonData['results'][0]['position']['lat'];
        $estate->address->longitude = $jsonData['results'][0]['position']['lon'];
        $estate->address->estate_id = $estate->id;
        $estate->address->save();

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

        return to_route('admin.estates.show', $estate->id)->with('alertType', 'success')->with('alertMessage', 'Annuncio modificato con successo')->with('alertTitle', "$estate->title");
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
        if ($estate->images) {
            Storage::deleteDirectory("estate_images/$estate->id");
        }

        if (count($estate->services)) $estate->services()->detach();
        if (count($estate->sponsorships)) $estate->sponsorships()->detach();

        $estate->forceDelete();

        return to_route('admin.estates.trash')
            ->with('alertType', 'danger')
            ->with('alertTitle', "$estate->title")
            ->with('alertMessage', "L'annuncio è stato cancellato correttamente!");
    }

    public function dropAll()
    {
        $estates = Estate::onlyTrashed()->get();
        $estates_count = Estate::onlyTrashed()->count();

        foreach ($estates as $estate) {

            // ! DA VERIFICARE CHE LA COVER E LE IMMAGINI SI CANCELLINO !
            if ($estate->images) {
                Storage::deleteDirectory("estate_images/$estate->id");
            }

            if (count($estate->services)) $estate->services()->detach();
            if (count($estate->sponsorships)) $estate->sponsorships()->detach();

            $estate->forceDelete();
        }

        return to_route('admin.estates.index')
            ->with('alertType', 'danger')
            ->with('alertMessage', "$estates_count annunci sono stati cancellati correttamente!");
    }

    public function restore(string $id)
    {
        $estate = Estate::onlyTrashed()->findOrFail($id);

        $estate->restore();

        return to_route('admin.estates.trash')
            ->with('alertType', 'success')
            ->with('alertTitle', "$estate->title")
            ->with('alertMessage', "L'annuncio è stato ripristinato!");
    }

    public function restoreAll()
    {
        $estates = Estate::onlyTrashed();
        $estates_count = Estate::onlyTrashed()->count();

        $estates->restore();

        return to_route('admin.estates.index')
            ->with('alertType', 'success')
            ->with('alertMessage', "$estates_count L'annuncio è stato ripristinato!");
    }

    public function get_query($data)
    {
        $arr_query = [];
        foreach ($data as $row) {
            $words = explode(' ', $row);
            foreach ($words as $word) {
                $arr_query[] = "$word%20";
            }
        }
        $query = implode($arr_query);
        return substr($query, 0, strlen($query) - 3);
    }
}
