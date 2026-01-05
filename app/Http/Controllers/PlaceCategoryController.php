<?php

namespace App\Http\Controllers;

use App\Models\Chemical;
use App\Models\PlaceCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlaceCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = PlaceCategory::query()->withCount('places')->with('chemicals');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        return Inertia::render('PlaceCategories/Index', [
            'categories' => $query->get(),
            'filters' => $request->only(['search'])
        ]);
    }

    public function create()
    {
        return Inertia::render('PlaceCategories/Create', [
            'chemicals' => Chemical::select('id', 'name', 'chemical_type')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'required_equipment' => 'nullable|array', // Legacy array or new structure
            'chemicals' => 'nullable|array', // New pivot array of IDs
            'chemicals.*' => 'exists:chemicals,id',
            'icon' => 'nullable|string',
        ]);

        // Keep required_equipment for backward compatibility if needed, or just null it
        // We will focus on pivot table now.
        // But for display in old views, we might want to keep the JSON? 
        // No, let's move forward. The user approved the refactor.
        // We can just save an empty array or null for required_equipment since we are replacing it.
        $validated['required_equipment'] = json_encode([]); 

        $category = PlaceCategory::create([
            'name' => $validated['name'],
            'required_equipment' => json_encode([]), // Deprecated
            'icon' => $validated['icon'] ?? null,
        ]);

        if (!empty($validated['chemicals'])) {
            $category->chemicals()->sync($validated['chemicals']);
        }
        
        if ($request->wantsJson()) {
            return response()->json($category);
        }

        return redirect()->route('place-categories.index')->with('success', 'Place Category created successfully.');
    }

    public function edit(PlaceCategory $placeCategory)
    {
        $placeCategory->load('chemicals');
        return Inertia::render('PlaceCategories/Edit', [
            'category' => $placeCategory,
            'chemicals' => Chemical::select('id', 'name', 'chemical_type')->get()
        ]);
    }

    public function update(Request $request, PlaceCategory $placeCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'chemicals' => 'nullable|array',
            'chemicals.*' => 'exists:chemicals,id',
            'icon' => 'nullable|string',
        ]);

        $placeCategory->update([
            'name' => $validated['name'],
            'icon' => $validated['icon'] ?? $placeCategory->icon,
        ]);

         if ($request->has('chemicals')) {
            $placeCategory->chemicals()->sync($validated['chemicals']);
        }

        return redirect()->route('place-categories.index')->with('success', 'Place Category updated successfully.');
    }

    public function destroy(PlaceCategory $placeCategory)
    {
        $placeCategory->delete();
        return redirect()->route('place-categories.index')->with('success', 'Place Category deleted successfully.');
    }
}
