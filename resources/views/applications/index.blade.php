@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-800">Your Applications</h1>

            <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                <!-- Search & Filter -->
                <form method="GET" action="{{ route('applications.index') }}" class="flex items-center space-x-2">
                    <input type="text" name="search" placeholder="Search company or position"
                           value="{{ request('search') }}"
                           class="border border-gray-300 rounded px-3 py-1 text-sm w-64" />

                    <select name="status" onchange="this.form.submit()"
                            class="border border-gray-300 rounded px-3 py-1 text-sm">
                        <option value="">Statuses</option>
                        @foreach (['Wishlist', 'Applied', 'Interviewing', 'Offered', 'Rejected', 'Accepted'] as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                        🔍 Search
                    </button>
                </form>
            </div>
        </div>

        @forelse ($applications as $app)
            <div class="bg-white p-5 mb-4 rounded-lg shadow-sm hover:shadow-md transition">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                    <div class="mb-3 sm:mb-0">
                        <h2 class="text-lg font-semibold text-gray-800">{{ $app->company }}</h2>
                        <p class="text-sm text-gray-600">{{ $app->position }}</p>
                        <span class="inline-block mt-1 px-2 py-0.5 text-xs font-medium rounded-full
                            @class([
                                'bg-gray-200 text-gray-800' => $app->status === 'Wishlist',
                                'bg-blue-100 text-blue-800' => $app->status === 'Applied',
                                'bg-yellow-100 text-yellow-800' => $app->status === 'Interviewing',
                                'bg-green-100 text-green-800' => $app->status === 'Offered',
                                'bg-red-100 text-red-800' => $app->status === 'Rejected',
                                'bg-indigo-100 text-indigo-800' => $app->status === 'Accepted',
                            ])">
                            {{ $app->status }}
                        </span>
                    </div>

                    <div class="flex space-x-4 text-sm">
                        <a href="{{ route('applications.show', $app->id) }}"
                           class="text-gray-600 hover:text-gray-800">View</a>

                        <a href="{{ route('applications.edit', $app->id) }}"
                           class="text-blue-500 hover:text-blue-700">Edit</a>

                        <form action="{{ route('applications.destroy', $app->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-400 mt-10">No applications found.</p>
        @endforelse

        <!-- Pagination -->
        <div class="mt-6">
            {{ $applications->links() }}
        </div>
    </div>
@endsection
