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
    </style>
</head>

<body class="bg-white dark:bg-slate-900 min-h-screen overflow-hidden">
    
    <x-navbar />

    <div class="flex h-screen pt-16">
        {{-- SIDEBAR --}}
        <aside class="w-72 flex-shrink-0 fixed left-0 top-16 h-[calc(100vh-4rem)] overflow-y-auto custom-scrollbar bg-white dark:bg-slate-900 border-r border-gray-100 dark:border-white/5 z-40">
            <div class="p-4">
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
        <main class="flex-1 ml-72 h-[calc(100vh-4rem)] overflow-y-auto custom-scrollbar bg-white dark:bg-slate-900 transition-all duration-300">
            <div class="px-8 py-8"> {{-- Padding langsung di sini, tanpa card lagi --}}
                
                {{-- Alert System --}}
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 bg-blue-500/5 border border-blue-500/10 rounded-xl flex items-center justify-between">
                        <span class="text-blue-600 dark:text-blue-400 text-sm font-medium">{{ session('success') }}</span>
                        <button @click="show = false" class="text-blue-400 hover:text-blue-600">&times;</button>
                    </div>
                @endif

                {{-- SLOT LANGSUNG NYATU --}}
                <div class="min-h-full">
                    {{ $slot }}
                </div>

                {{-- Minimal Footer --}}
                <footer class="mt-12 pb-8 border-t border-gray-50 dark:border-white/5 pt-6 text-gray-400 text-[10px] uppercase tracking-widest text-center">
                    SIMPEL-5 &bull; SMKN 5 Kabupaten Tangerang &bull; {{ date('Y') }}
                </footer>
            </div>
        </main>
    </div>

    @stack('modals')
    @stack('scripts')
</body>
</html>