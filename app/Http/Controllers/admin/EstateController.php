<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\Service;
use Illuminate\Http\Request;

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
        $data = $request->all();

        // Change is_visible switch value to boolean one.
        $data['is_visible'] = isset($data['is_visible']);

        $estate = new Estate;
        $estate->fill($data);
        $estate->save();

        return to_route('admin.estates.create', $estate);
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
        $data = $request->all();
        $estate->update($data);
        return to_route('admin.estates.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estate $estate)
    {
        //
    }
}
