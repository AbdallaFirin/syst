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
            $query = FireIncident::with(['place.category', 'cause'])
                ->whereBetween('incident_date', [$startDate, $endDate]);

            if ($request->has('cause_id') && $request->cause_id) {
                $query->where('incident_cause_id', $request->cause_id);
            }

            if ($request->has('category_id') && $request->category_id) {
                $query->whereHas('place', function ($q) use ($request) {
                    $q->where('place_category_id', $request->category_id);
                });
            }

            $incidents = $query->latest('incident_date')->get();

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

             // Chart Data 1: Incidents by Cause
            $incidentsByCause = $incidents->groupBy('incident_cause_id')->map(function ($row) {
                return [
                    'cause' => $row->first()->cause->name ?? 'Unknown',
                    'count' => $row->count(),
                    'color' => '#' . substr(md5($row->first()->incident_cause_id), 0, 6) // Deterministic color
                ];
            })->values();

            // Chart Data 2: Monthly Trends
            $monthlyTrends = $incidents->groupBy(function ($d) {
                return \Carbon\Carbon::parse($d->incident_date)->format('Y-m');
            })->map(function ($row) {
                return [
                    'month' => \Carbon\Carbon::parse($row->first()->incident_date)->format('M Y'),
                    'count' => $row->count(),
                    'loss' => $row->sum('financial_loss')
                ];
            })->sortBy(function($row, $key) {
                return $key; 
            })->values();

            $data = [
                'incidents' => $incidents,
                'trainings' => $trainings,
                'maintenance' => $maintenance,
                'awareness' => $awareness,
                'summary' => $summary,
                'charts' => [
                    'by_cause' => $incidentsByCause,
                    'monthly_trends' => $monthlyTrends
                ]
            ];
        }

        return Inertia::render('Reports/Index', [
            'reportData' => $data,
            'filters' => $request->only(['start_date', 'end_date', 'cause_id', 'category_id']),
            'causes' => \App\Models\IncidentCause::all(),
            'categories' => \App\Models\PlaceCategory::all(),
        ]);
    }
    public function export(Request $request) {
        $startDate = $request->start_date;
        $endDate = $request->end_date . ' 23:59:59';

        $query = FireIncident::with(['place.category', 'cause'])
            ->whereBetween('incident_date', [$startDate, $endDate]);

        if ($request->has('cause_id') && $request->cause_id) {
            $query->where('incident_cause_id', $request->cause_id);
        }

        if ($request->has('category_id') && $request->category_id) {
            $query->whereHas('place', function ($q) use ($request) {
                $q->where('place_category_id', $request->category_id);
            });
        }

        $incidents = $query->latest('incident_date')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="fire_safety_report_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($incidents) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date', 'Category', 'Place', 'Cause', 'Human Loss (Dead)', 'Injured', 'Financial Loss', 'Rescued']);

            foreach ($incidents as $incident) {
                fputcsv($file, [
                    $incident->incident_date,
                    $incident->place->category->name ?? 'N/A',
                    $incident->place->name ?? 'N/A',
                    $incident->cause->name ?? 'N/A',
                    $incident->human_loss,
                    $incident->injured_people,
                    $incident->financial_loss,
                    $incident->rescued_people
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
