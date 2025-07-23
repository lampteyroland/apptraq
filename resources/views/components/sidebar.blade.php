<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AppTraq</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-800" x-data="{ sidebarOpen: false }">

<div class="min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md hidden sm:flex flex-col justify-between h-screen relative">
        <!-- Top Section: Logo + Navigation -->
        <div>
            <div class="p-6 border-b">
                <h1 class="text-2xl font-bold">AppTracker</h1>
            </div>
            <nav class="p-4 space-y-2 text-sm">
                <!-- Your nav links -->
            </nav>
        </div>

        <!-- Bottom Section: User Info -->
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

            <div x-show="open" @click.away="open = false" x-cloak
                 class="mt-2 bg-white border rounded shadow text-sm">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black opacity-30 sm:hidden z-30" x-cloak></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Mobile Top Bar -->
        <header class="bg-white shadow-sm p-4 sm:hidden flex items-center justify-between">
            <button @click="sidebarOpen = true" class="text-gray-600 hover:text-gray-900">☰</button>
            <h2 class="text-lg font-bold">AppTraq</h2>
            <div></div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>
    </div>

</div>

</body>
</html>
