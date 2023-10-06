<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\Image;
use App\Models\Message;
use App\Models\Service;
use App\Models\Sponsorship;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EstateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $currentYear = date('Y');
        $estates = Estate::orderBy('updated_at', 'DESC')->get();


        // Visits filtered by currrent year, months, all estates for singole id, and ip address count only 1 visit every day
        $monthlyVisitsData = DB::table('visits')
            ->join('estates', 'visits.estate_id', '=', 'estates.id')
            ->where('estates.user_id', $userId)
            ->whereYear('visits.created_at', $currentYear)
            ->select(DB::raw('MONTH(visits.created_at) as month'), DB::raw('COUNT(DISTINCT DATE(visits.created_at), visits.ip_address) as count'))
            ->groupBy(DB::raw('MONTH(visits.created_at)'))
            ->pluck('count', 'month')
            ->toArray();
        $allMonths = array_fill(1, 12, 0);
        $monthlyVisits = $monthlyVisitsData + $allMonths;
        $monthlyVisitsJSON = json_encode($monthlyVisits);

        return view('admin.estates.index', compact('estates', 'monthlyVisitsJSON'));
    }

    public function messages()
    {
        $userId = Auth::id();

        $messages = Message::whereHas('estate', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->orderBy('updated_at', 'DESC')->get();

        return view('admin.estates.messages', compact('messages'));
    }

    public function promo(string $id)
    {
        $estate = Estate::findOrFail($id);
        if (Auth::id() !== $estate->user_id) {
            return abort(401);
        }
        $sponsorships = Sponsorship::all();
        $data = compact('estate', 'sponsorships');
        return view('admin.estates.promo', $data);
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
                'address' => 'required|string|max:50',
                'services' => 'required|array',


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
                'address.required' => "L'indirizzo è obbligatorio.",
                'address.max' => "L'indirizzo deve essere lungo max 50 carattari.",

                // Images errors bag
                'multiple_images.required' => "È richiesta almeno un'immagine.",
                'multiple_images.image' => 'Le immagini devono essere di tipo jpeg,png,jpg,gif.',
                'multiple_images.mimes' => 'Le immagini devono essere di tipo jpeg,png,jpg,gif.',
                'multiple_images.max' => 'I file devono pesare max 2Mb.',

                // Services errors bag
                'services.required' => "L'annuncio deve contenere almeno un servizio",
                'services.array' => "L'annuncio deve contenere almeno un servizio",

            ]
        );
        $data = $request->all();

        // ############# ADDRESS #############
        // Push address into DB
        $api_key = 'M67vYPGoqcGCwsgAOqnQFq8m8VRJHYoW';
        $query = $data['address'];
        $response = Http::get("https://api.tomtom.com/search/2/geocode/$query.json?&key=$api_key");
        $jsonData = $response->json();

        // if (!count($jsonData['results'])) {
        //     return to_route('admin.estates.create')->with('alertType', 'danger')->with('alertMessage', 'Indirizzo è inesistente');
        // }

        $images = $request->file('multiple_images');

        // Change is_visible switch value to a boolean one.
        $data['is_visible'] = isset($data['is_visible']);

        $estate = new Estate;
        $estate->fill($data);
        $estate->user_id = Auth::user()->id;
        $estate->latitude = $jsonData['results'][0]['position']['lat'];
        $estate->longitude = $jsonData['results'][0]['position']['lon'];
        $estate->save();

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
    public function show(string $id)
    {
        $estate = Estate::withTrashed()->findOrFail($id);

        if (Auth::id() !== $estate->user_id) {
            return abort(401);
        }

        return view('admin.estates.show', compact('estate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $estate = Estate::findOrFail($id);

        if (Auth::id() !== $estate->user_id) {
            return abort(401);
        }
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
                'address' => 'required|string|max:50',
                'services' => 'required|array',


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
                'address.required' => "L'indirizzo è obbligatorio.",
                'address.max' => "L'indirizzo deve essere lungo max 50 carattari.",

                // Images errors bag
                'multiple_images.required' => "È richiesta almeno un'immagine.",
                'multiple_images.image' => 'Le immagini devono essere di tipo jpeg,png,jpg,gif.',
                'multiple_images.mimes' => 'Le immagini devono essere di tipo jpeg,png,jpg,gif.',
                'multiple_images.max' => 'I file devono pesare max 2Mb.',

                // Services errors bag
                'services.required' => "L'annuncio deve contenere almeno un servizio",
                'services.array' => "L'annuncio deve contenere almeno un servizio",
            ]
        );

        $data = $request->all();

        $estate = Estate::findOrFail($id);

        // ############# ADDRESS #############
        // Push address into DB
        $api_key = 'M67vYPGoqcGCwsgAOqnQFq8m8VRJHYoW';
        $query = $data['address'];
        $response = Http::get("https://api.tomtom.com/search/2/geocode/$query.json?&key=$api_key");
        $jsonData = $response->json();
        // if (!count($jsonData['results'])) {
        //     return to_route('admin.estates.create')->with('alertType', 'danger')->with('alertMessage', 'Indirizzo è inesistente');
        // }

        // Change is_visible switch value to boolean one.
        $data['is_visible'] = isset($data['is_visible']);
        $estate->latitude = $jsonData['results'][0]['position']['lat'];
        $estate->longitude = $jsonData['results'][0]['position']['lon'];
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
            ->with('alertMessage', 'è stato messo nel cestino!');
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
            ->with('alertMessage', "è stato cancellato correttamente!");
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
            ->with('alertMessage', "Tutti gli annunci sono stati cancellati correttamente!");
    }

    public function restore(string $id)
    {
        $estate = Estate::onlyTrashed()->findOrFail($id);

        $estate->restore();

        return to_route('admin.estates.trash')
            ->with('alertType', 'success')
            ->with('alertTitle', "$estate->title")
            ->with('alertMessage', "è stato ripristinato!");
    }

    public function restoreAll()
    {
        $estates = Estate::onlyTrashed();
        $estates_count = Estate::onlyTrashed()->count();

        $estates->restore();

        return to_route('admin.estates.index')
            ->with('alertType', 'success')
            ->with('alertMessage', "Tutti gli annunci sono stati ripristinati!");
    }
}
