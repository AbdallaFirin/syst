<?php

namespace App\Http\Controllers;

use App\Models\IncidentCause;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IncidentCauseController extends Controller
{
    public function index()
    {
        return Inertia::render('IncidentCauses/Index', [
            'causes' => IncidentCause::all()
        ]);
    }

    public function create()
    {
        return Inertia::render('IncidentCauses/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:incident_causes,name',
            'description' => 'nullable|string',
        ]);

        $cause = IncidentCause::create($validated);
        
        if ($request->wantsJson()) {
            return response()->json($cause);
        }

        return redirect()->route('incident-causes.index')->with('success', 'Incident Cause created successfully.');
    }

    public function edit(IncidentCause $incidentCause)
    {
        return Inertia::render('IncidentCauses/Edit', [
            'cause' => $incidentCause
        ]);
    }

    public function update(Request $request, IncidentCause $incidentCause)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:incident_causes,name,' . $incidentCause->id,
            'description' => 'nullable|string',
        ]);

        $incidentCause->update($validated);

        return redirect()->route('incident-causes.index')->with('success', 'Incident Cause updated successfully.');
    }

    public function destroy(IncidentCause $incidentCause)
    {
        $incidentCause->delete();
        return redirect()->route('incident-causes.index')->with('success', 'Incident Cause deleted successfully.');
    }
}
