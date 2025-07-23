@extends('layouts.app')

@section('content')
    <div class="text-center py-20">
        <h1 class="text-5xl font-bold text-gray-800">403</h1>
        <p class="text-lg mt-4 text-gray-500">You don't have permission to access this page.</p>
        <a href="{{ route('dashboard') }}" class="mt-6 inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            ← Back to Dashboard
        </a>
    </div>
@endsection
