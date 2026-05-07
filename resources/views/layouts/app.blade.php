<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SIMPEL-5 - Sistem Informasi PKL SMKN 5</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('favicon-n5.png') }}">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { 
            background: rgba(156, 163, 175, 0.2); 
            border-radius: 10px; 
        }

        :root {
            --primary-n5: #004aad; 
            --secondary-n5: #00d4ff; 
        }
    </style>
</head>

<body class="bg-white dark:bg-slate-900 min-h-screen overflow-hidden" 
    x-data="{ 
    isCollapsed: false, 
    mobileOpen: false, 
    darkMode: localStorage.getItem('theme') === 'dark' 
    }" 
    x-init="$watch('darkMode', val => document.documentElement.classList.toggle('dark', val))">
    
    {{-- 
        NAVBAR: 
    --}}
    <nav class="fixed top-0 z-50 w-full h-16 bg-white dark:bg-slate-900 border-b border-gray-100 dark:border-white/5 px-4 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <button @click="mobileOpen = !mobileOpen; isCollapsed = (window.innerWidth >= 768) ? !isCollapsed : false" 
                class="p-2 rounded-xl bg-gray-50 dark:bg-white/5 text-primary-n5 hover:bg-primary-n5/10 transition-all duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            
            <div class="flex items-center gap-2">
                <img src="{{ asset('favicon-n5.png') }}" class="w-8 h-8" alt="Logo">
                <span class="font-bold text-lg tracking-tight text-slate-800 dark:text-white hidden sm:block">SIMPEL-5</span>
            </div>
        </div>

        {{-- Slot Navbar (Profile, Dropdown, dll) --}}
        <x-navbar />
    </nav>

    <div class="flex h-screen pt-16">
        
        {{-- BACKDROP MOBILE --}}
        <div x-show="mobileOpen" 
             x-transition:enter="transition opacity-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition opacity-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileOpen = false" 
             class="fixed inset-0 z-30 bg-slate-900/60 backdrop-blur-sm md:hidden">
        </div>

        {{-- SIDEBAR --}}
        <aside 
            :class="{
                'w-72': !isCollapsed,
                'w-24': isCollapsed, 
                'translate-x-0': mobileOpen,
                '-translate-x-full': !mobileOpen
            }"
            class="fixed md:static inset-y-0 left-0 top-16 z-40 flex-shrink-0 bg-white dark:bg-slate-900 border-r border-gray-100 dark:border-white/5 transition-all duration-300 ease-in-out md:translate-x-0 overflow-hidden">
            
            <div class="h-full py-4 overflow-y-auto overflow-x-hidden custom-scrollbar">
                @auth
                    @if(Auth::user()?->role === 'siswa')
                        <x-sidebar-siswa />
                    @elseif(Auth::user()?->role === 'guru')
                        <x-sidebar-guru />
                    @elseif(Auth::user()?->role === 'admin')
                        <x-sidebar-admin />
                    @endif
                @endauth
            </div>
        </aside>

        {{-- MAIN CONTENT AREA --}}
        <main class="flex-1 h-[calc(100vh-4rem)] overflow-y-auto custom-scrollbar bg-white dark:bg-slate-900 transition-all duration-300">
            <div class="px-4 md:px-8 py-8">
                
{{-- Alert System Global di app.blade.php --}}
@if(session('success') || session('error'))
    <div class="mb-6 space-y-3"> {{-- Container utama --}}
        
        {{-- Alert Success --}}
        @if(session('success'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 5000)" 
                 class="p-4 bg-green-50/80 dark:bg-green-500/10 border border-green-200 dark:border-green-500/20 rounded-2xl flex items-center justify-between shadow-sm backdrop-blur-sm animate-fade-in">
                <div class="flex items-center">
                    <div class="bg-green-500 p-2 rounded-xl mr-4 shadow-lg shadow-green-500/30">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <p class="text-green-800 dark:text-green-400 font-bold text-sm">Berhasil!</p>
                        <p class="text-green-600 dark:text-green-500/80 text-xs">{{ session('success') }}</p>
                    </div>
                </div>
                <button @click="show = false" class="text-green-400 hover:text-green-600">&times;</button>
            </div>
        @endif

        {{-- Alert Error --}}
        @if(session('error'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 class="p-4 bg-red-50/80 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 rounded-2xl flex items-center justify-between shadow-sm backdrop-blur-sm animate-shake">
                <div class="flex items-center">
                    <div class="bg-red-500 p-2 rounded-xl mr-4 shadow-lg shadow-red-500/30">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <div>
                        <p class="text-red-800 dark:text-red-400 font-bold text-sm">Opps, Ada Masalah!</p>
                        <p class="text-red-600 dark:text-red-500/80 text-xs">{{ session('error') }}</p>
                    </div>
                </div>
                <button @click="show = false" class="text-red-400 hover:text-red-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

    </div> {{-- Penutup space-y-3 --}}
@endif

                {{-- SLOT CONTENT --}}
                <div class="min-h-full">
                    {{ $slot }}
                </div>

                {{-- Minimal Footer --}}
                <footer class="mt-12 pb-8 border-t border-gray-50 dark:border-white/5 pt-6 text-gray-400 text-[10px] uppercase tracking-[0.2em] text-center">
                    SIMPEL-5 &bull; SMKN 5 Kabupaten Tangerang &bull; {{ date('Y') }}
                </footer>
            </div>
        </main>
    </div>

    @stack('modals')
    @stack('scripts')
</body>
</html>