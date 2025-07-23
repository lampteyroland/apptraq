@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">📝 New Application</h2>

        <form
            x-data="applicationForm()"
            x-init="loadDraft()"
            @input.debounce.1000="saveDraft"
            method="POST"
            action="{{ route('applications.store') }}"
            enctype="multipart/form-data"
            class="space-y-5"
        >
            @csrf

            <!-- Company -->
            <div>
                <x-input-label for="company" value="Company" />
                <x-text-input id="company" name="company" class="w-full mt-1" required />
                @error('company')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Position -->
            <div>
                <x-input-label for="position" value="Position" />
                <x-text-input id="position" name="position" class="w-full mt-1" required />
                @error('position')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <x-input-label for="status" value="Status" />
                <select name="status" class="w-full mt-1 border-gray-300 rounded">
                    @foreach (['Wishlist', 'Applied', 'Interviewing', 'Offered', 'Rejected', 'Accepted'] as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                    @endforeach
                </select>
                @error('status')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Applied On -->
            <div>
                <x-input-label for="applied_on" value="Applied On" />
                <x-text-input id="applied_on" type="date" name="applied_on" class="w-full mt-1" />
                @error('applied_on')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deadline -->
            <div>
                <x-input-label for="deadline" value="Deadline" />
                <x-text-input id="deadline" type="date" name="deadline" class="w-full mt-1" />
                @error('deadline')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location -->
            <div>
                <x-input-label for="location" value="Location" />
                <x-text-input id="location" name="location" class="w-full mt-1" />
                @error('location')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Job Link -->
            <div>
                <x-input-label for="job_link" value="Job Link (optional)" />
                <x-text-input id="job_link" type="url" name="job_link" class="w-full mt-1" />
                @error('job_link')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Resume Upload -->
            <div>
                <x-input-label for="resume_used" value="Resume (PDF)" />
                <input type="file" name="resume_used" id="resume_used" accept="application/pdf"
                       class="w-full mt-1 border rounded px-3 py-2">
                @error('resume_used')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div>
                <x-input-label for="notes" value="Notes" />
                <textarea id="notes" name="notes" rows="4" class="w-full border rounded p-2 mt-1"></textarea>
                @error('notes')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div class="pt-4">
                <x-primary-button>Save Application</x-primary-button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        function applicationForm() {
            return {
                formData: {},

                loadDraft() {
                    const saved = localStorage.getItem('draftApplication');
                    if (saved) {
                        this.formData = JSON.parse(saved);
                        for (const [key, value] of Object.entries(this.formData)) {
                            const field = document.querySelector(`[name="${key}"]`);
                            if (field) field.value = value;
                        }
                    }
                },

                saveDraft() {
                    const inputs = document.querySelectorAll('form [name]');
                    inputs.forEach(input => {
                        if (input.type !== 'file') {
                            this.formData[input.name] = input.value;
                        }
                    });
                    localStorage.setItem('draftApplication', JSON.stringify(this.formData));
                }
            };
        }
    </script>
@endsection
