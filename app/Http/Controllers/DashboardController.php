<?php

namespace App\Http\Controllers;

use App\Models\Chemical;
use App\Models\FireIncident;
use App\Models\Place;
use App\Models\Staff;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'stats' => [
                'total_places' => Place::count(),
                'total_staff' => Staff::count(),
                'total_vehicles' => Vehicle::count(),
                'total_incidents' => FireIncident::count(),
                'total_loss' => FireIncident::sum('financial_loss'),
                'expiring_chemicals' => Chemical::where('expiry_date', '<', now()->addMonths(3))->count(),
            ],
            'recent_incidents' => FireIncident::with(['place', 'cause'])
                ->latest('incident_date')
                ->take(5)
                ->get(),
            'expiring_chemicals_list' => Chemical::where('expiry_date', '<', now()->addMonths(3))
                ->where('expiry_date', '>', now()) // Optional: Don't show already expired? Or show all? User likely wants all 'problematic' ones. Let's show all expiring soon or expired.
                ->orderBy('expiry_date', 'asc')
                ->take(5)
                ->get(),
            'incidents_by_category' => FireIncident::join('places', 'fire_incidents.place_id', '=', 'places.id')
                ->join('place_categories', 'places.place_category_id', '=', 'place_categories.id')
                ->selectRaw('place_categories.name as category, count(*) as count')
                ->groupBy('place_categories.name')
                ->get()
        ]);
    }
}
