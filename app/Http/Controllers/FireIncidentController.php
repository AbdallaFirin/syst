<?php

namespace App\Http\Controllers;

use App\Models\FireIncident;
use App\Models\IncidentCause;
use App\Models\Place;
use App\Models\PlaceCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FireIncidentController extends Controller
{
    public function index(Request $request)
    {
        // Basic filtering can be added here
        $query = FireIncident::with(['place', 'cause'])->latest('incident_date');

        if ($request->filled('date')) {
            $query->whereDate('incident_date', $request->date);
        }

        return Inertia::render('FireIncidents/Index', [
            'incidents' => $query->get(),
            'filters' => $request->only(['date'])
        ]);
    }

    public function create()
    {
        return Inertia::render('FireIncidents/Create', [
            'places' => Place::all(),
            'causes' => IncidentCause::all(),
            'categories' => PlaceCategory::with('places')->get() // For cascading dropdown if needed, though simple place list might suffice for now
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'place_id' => 'required|exists:places,id',
            'incident_cause_id' => 'required|exists:incident_causes,id',
            'incident_date' => 'required|date',
            'human_loss' => 'required|integer|min:0',
            'injured_people' => 'required|integer|min:0',
            'financial_loss' => 'required|numeric|min:0',
            'property_damage' => 'nullable|string',
            'rescued_people' => 'required|integer|min:0',
            'rescued_assets' => 'nullable|string',
            'additional_notes' => 'nullable|string',
        ]);

        FireIncident::create($validated);

        return redirect()->route('fire-incidents.index')->with('success', 'Fire Incident registered successfully.');
    }

    public function edit(FireIncident $fireIncident)
    {
        return Inertia::render('FireIncidents/Edit', [
            'incident' => $fireIncident,
            'places' => Place::all(),
            'causes' => IncidentCause::all()
        ]);
    }

    public function update(Request $request, FireIncident $fireIncident)
    {
         $validated = $request->validate([
            'place_id' => 'required|exists:places,id',
            'incident_cause_id' => 'required|exists:incident_causes,id',
            'incident_date' => 'required|date',
            'human_loss' => 'required|integer|min:0',
            'injured_people' => 'required|integer|min:0',
            'financial_loss' => 'required|numeric|min:0',
            'property_damage' => 'nullable|string',
            'rescued_people' => 'required|integer|min:0',
            'rescued_assets' => 'nullable|string',
            'additional_notes' => 'nullable|string',
        ]);

        $fireIncident->update($validated);

        return redirect()->route('fire-incidents.index')->with('success', 'Fire Incident updated successfully.');
    }

    public function destroy(FireIncident $fireIncident)
    {
        $fireIncident->delete();
        return redirect()->route('fire-incidents.index')->with('success', 'Fire Incident deleted successfully.');
    }
}
