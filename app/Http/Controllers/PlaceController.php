<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\PlaceCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlaceController extends Controller
{
    public function index()
    {
        // Eager load places for categories to enable grouping on frontend.
        // Also simpler: just send all places (with category loaded) and all categories.
        // Or send Categories WITH places.
        
        $categories = PlaceCategory::with('places')->get();

        return Inertia::render('Places/Index', [
            'categories' => $categories
        ]);
    }

    public function create()
    {
        return Inertia::render('Places/Create', [
            'categories' => PlaceCategory::all(),
            'chemicals' => \App\Models\Chemical::select('name', 'chemical_type')->get()->unique('name')
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'place_category_id' => 'required|exists:place_categories,id',
            'location' => 'required|string',
            'contact_person' => 'required|string|max:255',
            'phone_number_1' => 'required|string|max:20',
            'phone_number_2' => 'nullable|string|max:20',
            'phone_number_3' => 'nullable|string|max:20',
        ]);

        $place = Place::create($validated);
        
        if ($request->wantsJson()) {
            return response()->json($place);
        }

        return redirect()->route('places.index')->with('success', 'Place registered successfully.');
    }

    public function edit(Place $place)
    {
        return Inertia::render('Places/Edit', [
            'place' => $place,
            'categories' => PlaceCategory::all(),
            'chemicals' => \App\Models\Chemical::select('name', 'chemical_type')->get()->unique('name')
        ]);
    }

    public function update(Request $request, Place $place)
    {
         $validated = $request->validate([
            'name' => 'required|string|max:255',
            'place_category_id' => 'required|exists:place_categories,id',
            'location' => 'required|string',
            'contact_person' => 'required|string|max:255',
            'phone_number_1' => 'required|string|max:20',
            'phone_number_2' => 'nullable|string|max:20',
            'phone_number_3' => 'nullable|string|max:20',
        ]);

        $place->update($validated);

        return redirect()->route('places.index')->with('success', 'Place updated successfully.');
    }

    public function destroy(Place $place)
    {
        $place->delete();
        return redirect()->route('places.index')->with('success', 'Place deleted successfully.');
    }
}
