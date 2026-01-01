<?php

namespace App\Http\Controllers;

use App\Models\AwarenessActivity;
use App\Models\FireIncident;
use App\Models\MaintenanceLog;
use App\Models\Training;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'incidents' => [],
            'trainings' => [],
            'maintenance' => [],
            'awareness' => [],
            'summary' => null
        ];

        if ($request->has(['start_date', 'end_date'])) {
            $startDate = $request->start_date;
            $endDate = $request->end_date . ' 23:59:59';

            // 1. Fire Incidents
            $incidents = FireIncident::with(['place.category', 'cause'])
                ->whereBetween('incident_date', [$startDate, $endDate])
                ->latest('incident_date')
                ->get();

            // 2. Trainings
            $trainings = Training::whereBetween('conducted_at', [$startDate, $endDate])
                ->latest('conducted_at')
                ->get();

            // 3. Maintenance Logs
            $maintenance = MaintenanceLog::whereBetween('performed_at', [$startDate, $endDate])
                ->latest('performed_at')
                ->get();

            // 4. Awareness Activities
            $awareness = AwarenessActivity::whereBetween('activity_date', [$startDate, $endDate])
                ->latest('activity_date')
                ->get();

            // Summary Calculation
            $summary = [
                'total_incidents' => $incidents->count(),
                'total_human_loss' => $incidents->sum('human_loss'),
                'total_injured' => $incidents->sum('injured_people'),
                'total_financial_loss' => $incidents->sum('financial_loss'),
                'total_rescued' => $incidents->sum('rescued_people'),
                
                'total_trainings' => $trainings->count(),
                'trained_staff' => $trainings->sum('attendees_count'),

                'maintenance_cost' => $maintenance->sum('cost'),
                'maintenance_count' => $maintenance->count(),

                'awareness_activities' => $awareness->count(),
                'beneficiaries' => $awareness->sum('beneficiaries_count'),
                'property_damage_count' => $incidents->filter(fn($i) => !empty($i->property_damage))->count(),
            ];

            $data = [
                'incidents' => $incidents,
                'trainings' => $trainings,
                'maintenance' => $maintenance,
                'awareness' => $awareness,
                'summary' => $summary,
            ];
        }

        return Inertia::render('Reports/Index', [
            'reportData' => $data,
            'filters' => $request->only(['start_date', 'end_date'])
        ]);
    }
}
