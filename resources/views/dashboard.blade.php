@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">📊 Dashboard</h1>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-5 rounded shadow">
                <p class="text-sm text-gray-500">Total Applications</p>
                <p class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white p-5 rounded shadow">
                <p class="text-sm text-gray-500">Interviews</p>
                <p class="text-2xl font-bold text-yellow-600 mt-2">{{ $stats['interviewing'] }}</p>
            </div>
            <div class="bg-white p-5 rounded shadow">
                <p class="text-sm text-gray-500">Offers Received</p>
                <p class="text-2xl font-bold text-green-600 mt-2">{{ $stats['offered'] }}</p>
            </div>
            <div class="bg-white p-5 rounded shadow">
                <p class="text-sm text-gray-500">Rejections</p>
                <p class="text-2xl font-bold text-red-500 mt-2">{{ $stats['rejected'] }}</p>
            </div>

        </div>


        <!-- Weekly Motivation -->
        @if($thisWeekCount > 0)
            <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 text-blue-800 p-4 rounded shadow-sm">
                <h1 class="text-2xl font-bold">Welcome, {{ auth()->user()->name }}!</h1>
                You've applied to <strong>{{ $thisWeekCount }}</strong> job{{ $thisWeekCount === 1 ? '' : 's' }} this week — nice consistency! Keep going!
            </div>
        @else
            <div class="mb-6 bg-gray-50 border-l-4 border-gray-300 text-gray-600 p-4 rounded shadow-sm">
                <h1 class="text-2xl font-bold">Welcome, {{ auth()->user()->name }}!</h1>
                No applications this week yet. A great time to apply! 💼
            </div>
        @endif


        <!-- 📅 Application Heatmap (GitHub Style) -->
        <div class="bg-white rounded shadow p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Application Activity ({{ $selectedYear }})</h2>

                <!-- Year Selector -->
                <form method="GET" action="{{ route('dashboard') }}">
                    <select  name="year" onchange="this.form.submit()"
                            class="border border-gray-300 rounded px-2 py-1 text-sm text-gray-700 w-20">
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}" @selected($selectedYear == $year)>{{ $year }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            @php
                use Carbon\Carbon;

                $end = Carbon::createFromDate($selectedYear, now()->month, now()->day)->endOfWeek();
                $start = $end->copy()->subYear()->addDay()->startOfWeek();

                $colors = [
                    0 => 'bg-gray-200',
                    1 => 'bg-green-100',
                    2 => 'bg-green-300',
                    3 => 'bg-green-500',
                    4 => 'bg-green-700',
                ];

                $weeks = [];
                $current = $start->copy();

                while ($current <= $end) {
                    $week = [];
                    for ($i = 0; $i < 7; $i++) {
                        $date = $current->copy();
                        $dateStr = $date->toDateString();
                        $count = $dateCounts[$dateStr] ?? 0;
                        $intensity = min(4, $count);
                        $week[] = [
                            'date' => $dateStr,
                            'count' => $count,
                            'color' => $colors[$intensity],
                            'day' => $date->dayOfWeekIso,
                            'month' => $date->format('M'),
                        ];
                        $current->addDay();
                    }
                    $weeks[] = $week;
                }

                                   $monthLabels = [];
                    $seenMonths = [];

                    foreach ($weeks as $i => $week) {
                        $label = $week[0]['month'];
                        if (!in_array($label, $seenMonths)) {
                            $monthLabels[$i] = $label;
                            $seenMonths[] = $label;
                        } else {
                            $monthLabels[$i] = '';
                        }
                    }

            @endphp

            <div class="overflow-x-auto">
                <!-- Month Labels -->
                <div class="flex ml-8 mb-1 space-x-[2px] text-xs text-gray-500">
                    @foreach ($monthLabels as $label)
                        <div class="w-6 text-center">{{ $label }}</div>
                    @endforeach
                </div>

                <!-- Heatmap Grid -->
                <div class="flex">
                    <!-- Day Labels (Mon-Sun) -->
                    <div class="flex flex-col mr-2 text-xs text-gray-400 space-y-[2px] mt-[12px]">
                        @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $label)
                            <div class="h-6 leading-6">{{ $label }}</div>
                        @endforeach
                    </div>

                    <!-- Cells -->
                    <div class="flex space-x-[2px]">
                        @foreach ($weeks as $week)
                            <div class="flex flex-col space-y-[2px]">
                                @foreach ($week as $cell)
                                    <div class="w-6 h-6 {{ $cell['color'] }} rounded-sm"
                                         title="{{ $cell['date'] }}: {{ $cell['count'] }} application{{ $cell['count'] === 1 ? '' : 's' }}">
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Legend -->
                <div class="flex items-center justify-end mt-4 text-xs text-gray-500 space-x-1">
                    <span>Less</span>
                    <div class="w-4 h-4 bg-gray-200 rounded-sm"></div>
                    <div class="w-4 h-4 bg-green-100 rounded-sm"></div>
                    <div class="w-4 h-4 bg-green-300 rounded-sm"></div>
                    <div class="w-4 h-4 bg-green-500 rounded-sm"></div>
                    <div class="w-4 h-4 bg-green-700 rounded-sm"></div>
                    <span>More</span>
                </div>
            </div>
        </div>

        <!-- Recent Applications -->
        <div class="bg-white rounded shadow p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Applications</h2>
            <ul class="divide-y divide-gray-100">
                @forelse ($recentApplications as $app)
                    <li class="py-4 flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-700">{{ $app->company }}</p>
                            <p class="text-xs text-gray-400">
                                {{ $app->position }} —
                                {{ $app->applied_on ? \Carbon\Carbon::parse($app->applied_on)->format('M d, Y') : 'N/A' }}
                            </p>
                        </div>
                        <a href="{{ route('applications.show', $app->id) }}"
                           class="text-blue-500 text-sm hover:underline">
                            View
                        </a>
                    </li>
                @empty
                    <li class="py-4 text-gray-400">No recent applications found.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
