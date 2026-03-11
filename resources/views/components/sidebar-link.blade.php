@props(['route', 'label', 'icon' => null, 'collapsed' => false])

@php
    $url = "#";
    $isActive = false;

    // Cek apakah route ada
    if (Route::has($route)) {
        $url = route($route);
        
        // Logika Aktif
        // Dashboard: Harus pas
        if (str_contains($route, 'dashboard')) {
            $isActive = request()->routeIs($route);
        } else {
            // Menu lain: Aktif jika di route itu atau anak-anaknya (index, create, edit, dll)
            $isActive = request()->routeIs($route) || request()->routeIs($route . '.*');
        }
    } else {
        // DEBUG MODE: Biar lo tau route mana yang typo
        if (config('app.debug')) {
            $url = "ROUTE_NOT_FOUND_CHECK_WEB_PHP_FOR_" . strtoupper($route);
        }
    }
@endphp

<a href="{{ $url }}"
    class="group relative flex items-center px-3 py-3 rounded-xl text-sm font-medium transition-all duration-200 mb-2
    {{ $isActive
        ? 'bg-gradient-to-r from-secondary-n5/20 to-secondary-n5/20 border border-primary-n5/30 shadow-lg text-primary-n5 dark:text-white'
        : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/10 hover:border-gray-200 dark:hover:border-white/20 border border-transparent' }}"
    title="{{ $collapsed ? $label : '' }}">

    {{-- Garis Indikator Samping --}}
    @if($isActive)
    <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-1.5 h-8 bg-gradient-to-b from-primary-n5 to-secondary-n5 rounded-r-full shadow-[0_0_10px_rgba(59,130,246,0.5)]"></div>
    @endif

    {{-- Icon Wrapper --}}
    <div class="flex-shrink-0 w-5 h-5 transition-transform duration-200 {{ $collapsed ? 'mx-auto' : 'mr-3' }} {{ $isActive ? 'scale-110' : 'group-hover:scale-110' }}">
        @if($icon)
            {!! $icon !!}
        @else
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
        @endif
    </div>

    {{-- Label --}}
    @if(!$collapsed)
    <span class="flex-1 truncate">{{ $label }}</span>
    
    @if($isActive)
    <svg class="w-4 h-4 ml-2 opacity-70 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
    </svg>
    @endif
    @endif

    {{-- Tooltip (Collapsed Mode) --}}
    @if($collapsed)
    <div class="absolute left-full ml-4 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity whitespace-nowrap z-50">
        {{ $label }}
    </div>
    @endif
</a>