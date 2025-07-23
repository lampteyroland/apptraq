<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-800" x-data="{ sidebarOpen: false }">

<div class="min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md hidden sm:block">
        <div class="p-6 border-b">
            <h1 class="text-2xl font-bold">AppTracker</h1>
        </div>
        <nav class="p-4 space-y-2 text-sm">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-gray-200 font-semibold' : '' }}">
                🏠 Dashboard
            </a>
            <a href="{{ route('applications.index') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('applications.*') ? 'bg-gray-200 font-semibold' : '' }}">
                📋 Applications
            </a>
            <a href="{{ route('applications.create') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-100">
                ➕ New Application
            </a>
            <span class="block px-3 py-2 text-gray-400">
                ⚙️ Settings (coming soon)
            </span>
        </nav>

        <!-- User Info at Bottom -->
        <div class="border-t p-4 mt-auto" x-data="{ open: false }">
            <button @click="open = !open" class="w-full flex items-center justify-between text-sm font-medium text-left">
                <div>
                    <div>{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" @click.away="open = false" x-cloak class="mt-2 bg-white border rounded shadow text-sm">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black opacity-30 sm:hidden z-30" x-cloak></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col w-full">

        <!-- Mobile Top Bar -->
        <header class="bg-white shadow-sm p-4 sm:hidden flex items-center justify-between">
            <button @click="sidebarOpen = true" class="text-gray-600 hover:text-gray-900">☰</button>
            <h2 class="text-lg font-bold">AppTracker</h2>
            <div></div>
        </header>

        <!-- Page Header -->
        @isset($header)
            <div class="bg-white shadow px-6 py-4">
                {{ $header }}
            </div>
        @endisset

        <!-- Main Content Area -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>
