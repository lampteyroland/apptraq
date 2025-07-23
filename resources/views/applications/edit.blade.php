@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Application</h2>

        <form method="POST" action="{{ route('applications.update', $application->id) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Company -->
            <div>
                <x-input-label for="company" value="Company" />
                <x-text-input id="company" name="company" class="w-full mt-1"
                              value="{{ old('company', $application->company) }}" required />
                @error('company')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Position -->
            <div>
                <x-input-label for="position" value="Position" />
                <x-text-input id="position" name="position" class="w-full mt-1"
                              value="{{ old('position', $application->position) }}" required />
                @error('position')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <x-input-label for="status" value="Status" />
                <select name="status" class="w-full mt-1 border-gray-300 rounded">
                    @foreach (['Wishlist', 'Applied', 'Interviewing', 'Offered', 'Rejected', 'Accepted'] as $status)
                        <option value="{{ $status }}" {{ $application->status == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Applied On -->
            <div>
                <x-input-label for="applied_on" value="Applied On" />
                <x-text-input id="applied_on" type="date" name="applied_on" class="w-full mt-1"
                              value="{{ old('applied_on', optional($application->applied_on)->format('Y-m-d')) }}" />
                @error('applied_on')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deadline -->
            <div>
                <x-input-label for="deadline" value="Deadline" />
                <x-text-input id="deadline" type="date" name="deadline" class="w-full mt-1"
                              value="{{ old('deadline', optional($application->deadline)->format('Y-m-d')) }}" />
                @error('deadline')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location -->
            <div>
                <x-input-label for="location" value="Location" />
                <x-text-input id="location" name="location" class="w-full mt-1"
                              value="{{ old('location', $application->location) }}" />
                @error('location')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Job Link -->
            <div>
                <x-input-label for="job_link" value="Job Link (optional)" />
                <x-text-input id="job_link" name="job_link" type="url" class="w-full mt-1"
                              value="{{ old('job_link', $application->job_link) }}" />
                @error('job_link')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Resume Upload -->
            <div>
                <x-input-label for="resume_used" value="Resume (PDF)" />
                <input type="file" name="resume_used" id="resume_used" accept="application/pdf"
                       class="w-full mt-1 border rounded px-3 py-2" />
                @error('resume_used')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div>
                <x-input-label for="notes" value="Notes" />
                <textarea id="notes" name="notes" rows="4"
                          class="w-full border rounded p-2 mt-1">{{ old('notes', $application->notes) }}</textarea>
                @error('notes')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div class="pt-4">
                <x-primary-button>Update Application</x-primary-button>
            </div>
        </form>
    </div>
@endsection
