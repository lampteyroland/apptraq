@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $application->position }}</h1>
                    <p class="text-gray-600 text-sm">{{ $application->company }}</p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                    {{ $application->status }}
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm text-gray-700">
                <div>
                    <p class="font-medium text-gray-500">Applied On</p>
                    <p>{{ $application->applied_on ? \Carbon\Carbon::parse($application->applied_on)->toFormattedDateString() : '—' }}</p>
                </div>

                <div>
                    <p class="font-medium text-gray-500">Deadline</p>
                    <p>{{ $application->deadline ? \Carbon\Carbon::parse($application->deadline)->toFormattedDateString() : '—' }}</p>
                </div>

                <div>
                    <p class="font-medium text-gray-500">Location</p>
                    <p>{{ $application->location ?? '—' }}</p>
                </div>

                <div>
                    <p class="font-medium text-gray-500">Job Link</p>
                    @if ($application->job_link)
                        <a href="{{ $application->job_link }}" target="_blank" class="text-blue-500 underline">View Posting</a>
                    @else
                        <span>—</span>
                    @endif
                </div>

                <div>
                    <p class="font-medium text-gray-500">Resume Used</p>
                    @if ($application->resume_used)
                        <a href="{{ asset('storage/' . $application->resume_used) }}" target="_blank" class="text-blue-500 underline">📄 View Resume</a>
                    @else
                        <span>—</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Notes</h2>
            <p class="text-sm text-gray-700 whitespace-pre-line">
                {{ $application->notes ?? 'No notes provided.' }}
            </p>
        </div>

        <div class="flex justify-between items-center mt-4">
            <a href="{{ route('applications.index') }}" class="text-sm text-gray-500 hover:underline">
                ← Back to Applications
            </a>

            <div class="space-x-4">
                <a href="{{ route('applications.edit', $application->id) }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700">
                    ✏️ Edit
                </a>

                <form action="{{ route('applications.destroy', $application->id) }}" method="POST" class="inline"
                      onsubmit="return confirm('Are you sure you want to delete this application?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-500 text-white text-sm font-medium rounded hover:bg-red-600">
                        🗑️ Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
