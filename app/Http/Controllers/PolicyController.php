<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PolicyController extends Controller
{
    public function index()
    {
        return Inertia::render('Policies/Index', [
            'policies' => Policy::all()
        ]);
    }

    public function create()
    {
        return Inertia::render('Policies/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'file_path' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:10240', // Max 10MB
        ]);

        if ($request->hasFile('file_path')) {
            $path = $request->file('file_path')->store('policies', 'public');
            $validated['file_path'] = $path;
        }

        Policy::create($validated);

        return redirect()->route('policies.index')->with('success', 'Policy uploaded successfully.');
    }

    public function edit(Policy $policy)
    {
        return Inertia::render('Policies/Edit', [
            'policy' => $policy
        ]);
    }

    public function update(Request $request, Policy $policy)
    {
        $rules = [
            'name' => 'required|string|max:255',
        ];

        // Only validate file if a new one is uploaded
        if ($request->hasFile('file_path')) {
            $rules['file_path'] = 'file|mimes:pdf,doc,docx,jpg,png|max:10240';
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('file_path')) {
            // Delete old file
            if ($policy->file_path && Storage::disk('public')->exists($policy->file_path)) {
                Storage::disk('public')->delete($policy->file_path);
            }
            
            $path = $request->file('file_path')->store('policies', 'public');
            $validated['file_path'] = $path;
        }

        $policy->update($validated);

        return redirect()->route('policies.index')->with('success', 'Policy updated successfully.');
    }

    public function destroy(Policy $policy)
    {
        if ($policy->file_path && Storage::disk('public')->exists($policy->file_path)) {
            Storage::disk('public')->delete($policy->file_path);
        }
        
        $policy->delete();
        return redirect()->route('policies.index')->with('success', 'Policy deleted successfully.');
    }
}
