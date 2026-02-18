<?php

namespace App\Http\Controllers;

use App\Models\FireIncident;
use App\Models\IncidentImage;
use App\Models\IncidentCause;
use App\Models\Place;
use App\Models\PlaceCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class FireIncidentController extends Controller
{
    public function index(Request $request)
    {
        $query = FireIncident::with(['place', 'cause', 'images'])->latest('incident_date');

        if ($request->filled('date_from')) {
            $query->whereDate('incident_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('incident_date', '<=', $request->date_to);
        }

        if ($request->filled('cause_id')) {
            $query->where('incident_cause_id', $request->cause_id);
        }

        return Inertia::render('FireIncidents/Index', [
            'incidents' => $query->get(),
            'causes' => IncidentCause::all(),
            'filters' => $request->only(['date_from', 'date_to', 'cause_id'])
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
            'incident_date' => 'required|date|before_or_equal:now',
            'human_loss' => 'required|integer|min:0',
            'injured_people' => 'required|integer|min:0',
            'financial_loss' => 'required|numeric|min:0',
            'property_damage' => 'nullable|string',
            'rescued_people' => 'required|integer|min:0',
            'rescued_assets' => 'nullable|string',
            'additional_notes' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // Image validation
            'image_caption' => 'nullable|string|max:255',
            'death_evidence' => 'nullable|array',
            'death_evidence.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
            'injury_evidence' => 'nullable|array',
            'injury_evidence.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
        ]);

        $incidentData = collect($validated)->except(['image', 'image_caption', 'death_evidence', 'injury_evidence'])->toArray();
        $incident = FireIncident::create($incidentData);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('incident_images', 'public');
            
            $incident->images()->create([
                'image_path' => $path,
                'caption' => $request->image_caption,
                'category' => 'general'
            ]);
        }

        if ($request->hasFile('death_evidence')) {
            foreach($request->file('death_evidence') as $file) {
                $path = $file->store('incident_evidence', 'public');
                $incident->images()->create([
                    'image_path' => $path,
                    'category' => 'death_evidence',
                    'caption' => 'Death Casualty Evidence'
                ]);
            }
        }

        if ($request->hasFile('injury_evidence')) {
            foreach($request->file('injury_evidence') as $file) {
                $path = $file->store('incident_evidence', 'public');
                $incident->images()->create([
                    'image_path' => $path,
                    'category' => 'injury_evidence',
                    'caption' => 'Injury Casualty Evidence'
                ]);
            }
        }

        return redirect()->route('fire-incidents.index')->with('success', 'Fire Incident registered successfully.');
    }

    public function edit(FireIncident $fireIncident)
    {
        return Inertia::render('FireIncidents/Edit', [
            'incident' => $fireIncident->load('images'),
            'places' => Place::all(),
            'causes' => IncidentCause::all()
        ]);
    }

    public function update(Request $request, FireIncident $fireIncident)
    {
         $validated = $request->validate([
            'place_id' => 'required|exists:places,id',
            'incident_cause_id' => 'required|exists:incident_causes,id',
            'incident_date' => 'required|date|before_or_equal:now',
            'human_loss' => 'required|integer|min:0',
            'injured_people' => 'required|integer|min:0',
            'financial_loss' => 'required|numeric|min:0',
            'property_damage' => 'nullable|string',
            'rescued_people' => 'required|integer|min:0',
            'rescued_assets' => 'nullable|string',
            'additional_notes' => 'nullable|string',
            'status' => 'required|in:pending,investigating,resolved,closed',
            'death_evidence' => 'nullable|array',
            'death_evidence.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
            'injury_evidence' => 'nullable|array',
            'injury_evidence.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
        ]);

        $fireIncident->update(collect($validated)->except(['death_evidence', 'injury_evidence'])->toArray());

        if ($request->hasFile('death_evidence')) {
            foreach($request->file('death_evidence') as $file) {
                $path = $file->store('incident_evidence', 'public');
                $fireIncident->images()->create([
                    'image_path' => $path,
                    'category' => 'death_evidence',
                    'caption' => 'Death Casualty Evidence (Update)'
                ]);
            }
        }

        if ($request->hasFile('injury_evidence')) {
            foreach($request->file('injury_evidence') as $file) {
                $path = $file->store('incident_evidence', 'public');
                $fireIncident->images()->create([
                    'image_path' => $path,
                    'category' => 'injury_evidence',
                    'caption' => 'Injury Casualty Evidence (Update)'
                ]);
            }
        }

        return redirect()->route('fire-incidents.index')->with('success', 'Fire Incident updated successfully.');
    }

    public function destroy(FireIncident $fireIncident)
    {
        $fireIncident->delete();
        return redirect()->route('fire-incidents.index')->with('success', 'Fire Incident deleted successfully.');
    }
    public function uploadImage(Request $request, FireIncident $fireIncident)
    {
        $request->validate([
            'image' => 'required|image|max:2048', // 2MB max
            'caption' => 'nullable|string|max:255'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('incident_images', 'public');
            
            $fireIncident->images()->create([
                'image_path' => $path,
                'caption' => $request->caption
            ]);

            return back()->with('success', 'Image uploaded successfully.');
        }

        return back()->with('error', 'Image upload failed.');
    }

    public function deleteImage($id)
    {
        $image = IncidentImage::findOrFail($id);
        
        // Delete file from storage
        Storage::disk('public')->delete($image->image_path);
        
        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }

    public function caseFile(FireIncident $fireIncident)
    {
        $fireIncident->load(['place.category', 'cause', 'images']);
        
        return Inertia::render('FireIncidents/CaseFile', [
            'incident' => $fireIncident
        ]);
    }
}
