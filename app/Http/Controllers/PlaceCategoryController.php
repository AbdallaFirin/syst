<?php

namespace App\Http\Controllers;

use App\Models\Chemical;
use App\Models\PlaceCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlaceCategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('PlaceCategories/Index', [
            'categories' => PlaceCategory::all()
        ]);
    }

    public function create()
    {
        return Inertia::render('PlaceCategories/Create', [
            'chemicals' => Chemical::select('name', 'chemical_type')->get()->unique('name')
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'required_equipment' => 'required|array', // Validating as array
            'required_equipment.*' => 'string'
        ]);

        // Convert array to comma-separated string or JSON. 
        // Migration has it as 'text'. Let's use JSON for better structure, or simple comma separated.
        // User requirements usually imply just "list items". Comma separated is easier to read in simple text fields.
        // But JSON is safer. Let's use JSON encode.
        $validated['required_equipment'] = json_encode($validated['required_equipment']);

        $category = PlaceCategory::create($validated);
        
        if ($request->wantsJson()) {
            return response()->json($category);
        }

        return redirect()->route('place-categories.index')->with('success', 'Place Category created successfully.');
    }

    public function edit(PlaceCategory $placeCategory)
    {
        return Inertia::render('PlaceCategories/Edit', [
            'category' => $placeCategory,
            'chemicals' => Chemical::select('name', 'chemical_type')->get()->unique('name')
        ]);
    }

    public function update(Request $request, PlaceCategory $placeCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'required_equipment' => 'required|array',
            'required_equipment.*' => 'string'
        ]);

        $validated['required_equipment'] = json_encode($validated['required_equipment']);

        $placeCategory->update($validated);

        return redirect()->route('place-categories.index')->with('success', 'Place Category updated successfully.');
    }

    public function destroy(PlaceCategory $placeCategory)
    {
        $placeCategory->delete();
        return redirect()->route('place-categories.index')->with('success', 'Place Category deleted successfully.');
    }
}
