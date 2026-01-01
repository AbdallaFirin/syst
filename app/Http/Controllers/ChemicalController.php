<?php

namespace App\Http\Controllers;

use App\Models\Chemical;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChemicalController extends Controller
{
    public function index()
    {
        return Inertia::render('Chemicals/Index', [
            'chemicals' => Chemical::all()
        ]);
    }

    public function create()
    {
        return Inertia::render('Chemicals/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'chemical_type' => 'required|string|max:255',
            'manufacture_date' => 'required|date',
            'expiry_date' => 'required|date|after:manufacture_date',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
        ]);

        Chemical::create($validated);

        return redirect()->route('chemicals.index')->with('success', 'Chemical registered successfully.');
    }

    public function edit(Chemical $chemical)
    {
        return Inertia::render('Chemicals/Edit', [
            'chemical' => $chemical
        ]);
    }

    public function update(Request $request, Chemical $chemical)
    {
        $validated = $request->validate([
             'name' => 'required|string|max:255',
            'chemical_type' => 'required|string|max:255',
            'manufacture_date' => 'required|date',
            'expiry_date' => 'required|date|after:manufacture_date',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
        ]);

        $chemical->update($validated);

        return redirect()->route('chemicals.index')->with('success', 'Chemical updated successfully.');
    }

    public function destroy(Chemical $chemical)
    {
        $chemical->delete();
        return redirect()->route('chemicals.index')->with('success', 'Chemical deleted successfully.');
    }
}
