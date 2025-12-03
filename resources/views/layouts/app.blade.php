<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Warehouse Tracking System') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-white to-indigo-50 text-gray-900">
        @php
            $navLinks = [
                ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'M3 12l9-9 9 9M4 10v9a1 1 0 001 1h5v-6h4v6h5a1 1 0 001-1v-9'],
                ['label' => 'Warehouse Management', 'route' => 'locations.index', 'icon' => 'M4 7h16M4 11h16M4 15h7m3 0h4'],
                ['label' => 'Part Management', 'route' => 'parts.index', 'icon' => 'M4 6h16M4 10h16M4 14h10M4 18h10'],
                ['label' => 'Review Workflow', 'route' => 'counts.index', 'params' => ['view' => 'review'], 'icon' => 'M5 8h14M5 12h14M5 16h10'],
                ['label' => 'Approval Page', 'route' => 'counts.index', 'params' => ['view' => 'approval'], 'icon' => 'M9 12l2 2 4-4M4 6h16a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V7a1 1 0 011-1z'],
            ];
        @endphp
        <div class="min-h-screen flex">
            <aside class="hidden lg:flex lg:flex-col lg:w-64 xl:w-72 bg-white/80 backdrop-blur-xl border-r border-blue-100 shadow-xl">
                <div class="px-6 py-8">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div class="text-lg font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            Stock Opname
                        </div>
                    </div>
                    <p class="text-sm text-blue-600 font-medium">Operational Console</p>
                </div>
                <nav class="flex-1 px-4 space-y-1">
                    @foreach ($navLinks as $link)
                        @php
                            $isActiveRoute = request()->routeIs($link['route']);
                            $expectedView = $link['params']['view'] ?? null;
                            $currentView = request('view');
                            $isActiveView = $expectedView ? $expectedView === $currentView : !$currentView && empty($link['params']);
                            $active = $isActiveRoute && $isActiveView;
                        @endphp
                        <a href="{{ route($link['route'], $link['params'] ?? []) }}"
                           class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition {{ $active ? 'bg-gradient-to-r from-blue-500 to-indigo-500 text-white shadow-lg shadow-blue-200' : 'text-gray-600 hover:bg-blue-50' }}">
                            <span class="inline-flex items-center justify-center rounded-lg {{ $active ? 'bg-white/20 text-white' : 'bg-blue-50 text-blue-600' }} p-2">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="{{ $link['icon'] }}" />
                                </svg>
                            </span>
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </nav>

                <div class="mt-auto px-6 py-6 border-t border-blue-100 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-500 text-white font-semibold flex items-center justify-center shadow-lg">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-blue-600">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-xl border-2 border-blue-200 px-4 py-2 text-sm font-medium text-blue-600 hover:bg-blue-50 transition">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4" />
                                <path d="M10 17l5-5-5-5" />
                                <path d="M15 12H3" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </aside>

            <div class="flex-1 flex flex-col min-h-screen">
                <header class="bg-white/80 backdrop-blur-xl border-b border-blue-100 px-6 lg:px-10 py-4 flex items-center justify-between shadow-sm">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-blue-400 font-semibold">Stock Opname System</p>
                        <h1 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">@yield('page-title', 'Overview')</h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="hidden sm:flex flex-col text-right">
                            <span class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</span>
                            <span class="text-xs text-blue-600 font-medium">{{ ucfirst(str_replace('_', ' ', auth()->user()->role?->value ?? 'user')) }}</span>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </div>
                    </div>
                </header>

                <main class="flex-1 w-full px-4 py-8 md:px-10">
                    <div class="max-w-6xl mx-auto space-y-6">
                        @isset($header)
                            <div class="bg-white/80 backdrop-blur-xl rounded-2xl border border-blue-100 shadow-lg px-6 py-4">
                                {{ $header }}
                            </div>
                        @endisset
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
