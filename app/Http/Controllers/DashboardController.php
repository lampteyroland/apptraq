<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $selectedYear = $request->get('year', now()->year);

        // Define the end date as the current date in selected year
        $end = Carbon::createFromDate($selectedYear, now()->month, now()->day)->endOfWeek();
        $start = $end->copy()->subYear()->addDay()->startOfWeek();

        // Weekly applications for motivational banner
        $thisWeekCount = Application::where('user_id', $userId)
            ->whereBetween('applied_on', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        // Application stats by status
        $statuses = ['Wishlist', 'Applied', 'Interviewing', 'Offered', 'Rejected', 'Accepted'];
        $stats = ['total' => Application::where('user_id', $userId)->count()];

        foreach ($statuses as $status) {
            $stats[strtolower($status)] = Application::where('user_id', $userId)
                ->where('status', $status)
                ->count();
        }

        // Recent applications
        $recentApplications = Application::where('user_id', $userId)
            ->orderBy('applied_on', 'desc')
            ->take(5)
            ->get();

        // Heatmap data: applications grouped by applied_on
        $dateCounts = Application::where('user_id', $userId)
            ->whereNotNull('applied_on')
            ->whereBetween('applied_on', [$start->toDateString(), $end->toDateString()])
            ->selectRaw('DATE(applied_on) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        // Available years for dropdown
        $availableYears = Application::where('user_id', $userId)
            ->whereNotNull('applied_on')
            ->selectRaw('YEAR(applied_on) as year')
            ->distinct()
            ->pluck('year')
            ->sortDesc()
            ->values();

        return view('dashboard', compact(
            'stats',
            'recentApplications',
            'dateCounts',
            'selectedYear',
            'availableYears',
            'thisWeekCount'
        ));
    }
}
