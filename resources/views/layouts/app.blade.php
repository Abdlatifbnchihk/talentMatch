<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'TalentMatch') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                }
            }
        }
    </script>
    <style>
        .sidebar-link.active { background-color: #eef2ff; color: #4f46e5; border-left: 4px solid #4f46e5; }
        .nav-link.active { color: #4f46e5; border-bottom: 2px solid #4f46e5; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .animate-spin-slow { animation: spin 2s linear infinite; }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-600">
    <div class="min-h-screen">
        {{-- Top Navbar --}}
        <nav class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-slate-200 shadow-sm h-16">
            <div class="flex items-center justify-between h-16 px-4 lg:px-6">
                {{-- Left: Logo --}}
                <div class="flex items-center gap-3">
                    <svg class="w-7 h-7 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-lg font-semibold text-slate-800">TalentMatch</span>
                </div>

                {{-- Center: Nav Links (desktop) --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('offers.index') }}" class="nav-link text-sm font-medium text-slate-600 hover:text-indigo-600 transition-all duration-200 pb-1 {{ request()->routeIs('offers.*') ? 'active' : '' }}">
                        Offers
                    </a>
                </div>

                {{-- Right: Avatar Dropdown --}}
                <div class="flex items-center gap-4">
                    {{-- Mobile hamburger --}}
                    <button id="mobile-menu-btn" class="md:hidden p-2 text-slate-500 hover:text-slate-700">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    {{-- User dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                            <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center">
                                <span class="text-white text-sm font-medium">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</span>
                            </div>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-200 py-1 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 transition-all duration-200">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 transition-all duration-200">Log Out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mobile nav --}}
            <div id="mobile-menu" class="hidden md:hidden border-t border-slate-200 bg-white">
                <div class="px-4 py-3 space-y-2">
                    <a href="{{ route('offers.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 transition-all duration-200">Offers</a>
                </div>
            </div>
        </nav>

        {{-- Left Sidebar (desktop) --}}
        <aside class="hidden md:flex fixed left-0 top-16 bottom-0 w-60 bg-white border-r border-slate-200 flex-col z-40">
            <div class="flex-1 py-6 px-3 space-y-1">
                <a href="{{ route('offers.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 transition-all duration-200 {{ request()->routeIs('offers.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    My Offers
                </a>
                <a href="{{ route('candidates.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 transition-all duration-200 {{ request()->routeIs('candidates.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Candidates
                </a>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="md:ml-60 pt-16">
            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="mx-6 mt-4">
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center justify-between" role="alert">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm">{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="mx-6 mt-4">
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center justify-between" role="alert">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm">{{ session('error') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            {{-- Page Content --}}
            <div class="p-6 max-w-6xl mx-auto">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            <footer class="text-center text-sm text-slate-400 py-6">
                TalentMatch &copy; 2025 &middot; Internal HR Tool
            </footer>
        </main>
    </div>

    <script>
        document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>
