@extends('layouts.app')

@section('content')
    <div class="text-center py-20">
        <h1 class="text-5xl font-bold text-gray-800">404</h1>
        <p class="text-lg mt-4 text-gray-500">Oops! The page you're looking for doesn't exist.</p>
        <a href="{{ route('dashboard') }}" class="mt-6 inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            ← Back to Dashboard
        </a>
    </div>
@endsection
