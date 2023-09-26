<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estate $estate)
    {
        //
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
