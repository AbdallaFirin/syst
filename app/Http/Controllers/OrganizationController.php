<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class OrganizationController extends Controller
{
    // Show the settings form
    public function edit()
    {
        // Get the first record or create default
        $organization = Organization::firstOrCreate(
            ['id' => 1],
            ['name' => 'Fire Safety Department']
        );

        return Inertia::render('Organization/Edit', [
            'organization' => $organization
        ]);
    }

    // Update the settings
    public function update(Request $request)
    {
        $organization = Organization::firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_info' => 'nullable|string|max:255',
            'footer_info' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($organization->logo_path) {
                Storage::disk('public')->delete($organization->logo_path);
            }
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo_path'] = $path;
        }

        $organization->update($validated);

        return redirect()->back()->with('success', 'Organization settings updated successfully.');
    }
}
