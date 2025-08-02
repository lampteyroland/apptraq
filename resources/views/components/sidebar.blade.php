<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AppTraq</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body x-data="{ sidebarOpen: false }" class="bg-gray-100 text-gray-800">

<div class="min-h-screen flex">

    <!-- Sidebar (Fixed on Desktop) -->
    <aside class="hidden sm:flex flex-col justify-between w-64 bg-white shadow-md fixed top-0 left-0 h-screen z-40">
        <!-- Top: Logo + Navigation -->
        <div>
            <div class="p-6 border-b">
                <h1 class="text-2xl font-bold">AppTracker</h1>
            </div>
            <nav class="p-4 space-y-2 text-sm">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-gray-200 font-semibold' : '' }}">
                    🏠 Dashboard
                </a>
                <a href="{{ route('applications.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('applications.*') ? 'bg-gray-200 font-semibold' : '' }}">
                    📋 Applications
                </a>
                <a href="{{ route('applications.create') }}" class="block px-3 py-2 rounded hover:bg-gray-100">
                    ➕ New Application
                </a>
            </nav>
        </div>

        <!-- Bottom: User Info -->
        <div class="border-t p-4" x-data="{ open: false }">
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

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black opacity-30 sm:hidden z-30" x-cloak></div>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col w-full sm:ml-64 min-h-screen">

        <!-- Mobile Top Bar -->
        <header class="bg-white shadow-sm p-4 sm:hidden flex items-center justify-between">
            <button @click="sidebarOpen = true" class="text-gray-600 hover:text-gray-900 text-2xl">☰</button>
            <h2 class="text-lg font-bold">AppTraq</h2>
            <div></div>
        </header>

        <!-- Optional Page Header -->
        @isset($header)
            <div class="bg-white shadow px-6 py-4">
                {{ $header }}
            </div>
        @endisset

        <!-- Page Content (scrollable) -->
        <main class="flex-1 p-6 overflow-y-auto">
            {{ $slot }}
        </main>
    </div>

</div>

</body>
</html>
