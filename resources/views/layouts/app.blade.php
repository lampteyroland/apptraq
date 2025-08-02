<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AppTraq</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lucide Icons CDN (inline SVG use) -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>[x-cloak] { display: none !important; }</style>
</head>
<body x-data="{ sidebarOpen: false }" class="bg-gray-100 text-gray-800">

<div class="min-h-screen flex">

    <!-- Sidebar -->
    <aside
        x-cloak
        :class="{
            'translate-x-0': sidebarOpen,
            '-translate-x-full': !sidebarOpen
        }"
        class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out z-50 sm:translate-x-0 sm:flex sm:flex-col sm:justify-between sm:z-40 h-screen"
    >
        <div class="flex-1 flex flex-col justify-between h-full">
            <!-- Top -->
            <div>
                <div class="flex justify-between items-center p-6 border-b sm:justify-start">
                    <h1 class="text-2xl font-bold">AppTracker</h1>

                    <!-- Mobile Close Icon -->
                    <button @click="sidebarOpen = false" class="sm:hidden text-gray-600 hover:text-black">
                        <svg data-lucide="x" class="w-6 h-6"></svg>
                    </button>
                </div>

                <nav class="p-4 space-y-2 text-sm">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-gray-200 font-semibold' : '' }}">
                        <svg data-lucide="home" class="w-4 h-4"></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('applications.index') }}" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('applications.*') ? 'bg-gray-200 font-semibold' : '' }}">
                        <svg data-lucide="clipboard-list" class="w-4 h-4"></svg>
                        Applications
                    </a>
                    <a href="{{ route('applications.create') }}" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-100">
                        <svg data-lucide="plus-circle" class="w-4 h-4"></svg>
                        New Application
                    </a>
                </nav>
            </div>

            <!-- Bottom -->
            <div class="border-t p-4" x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex items-center justify-between text-sm font-medium text-left">
                    <div>
                        <div>{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                    <svg data-lucide="chevron-down" class="w-4 h-4 ml-2"></svg>
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
        </div>
    </aside>

    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak class="fixed inset-0 bg-black bg-opacity-40 sm:hidden z-40 transition-opacity"></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col w-full sm:ml-64 min-h-screen">

        <!-- Mobile Top Bar -->
        <header class="bg-white shadow-sm p-4 sm:hidden flex items-center justify-between">
            <button @click="sidebarOpen = true" class="text-gray-600 hover:text-gray-900 text-2xl">
                <svg data-lucide="menu" class="w-6 h-6"></svg>
            </button>
            <h2 class="text-lg font-bold">AppTraq</h2>
            <div></div>
        </header>

        <!-- Optional Header -->
        @isset($header)
            <div class="bg-white shadow px-6 py-4">
                {{ $header }}
            </div>
        @endisset

        <!-- Page Content -->
        <main class="flex-1 p-6 overflow-y-auto">
            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>

</div>

<!-- Init Lucide icons -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        lucide.createIcons();
    });
</script>

</body>
</html>
