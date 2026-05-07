@props(['route', 'label', 'icon' => null])

@php
    $url = "#";
    $isActive = false;

    if (Route::has($route)) {
        $url = route($route);
        $isActive = str_contains($route, 'dashboard') 
            ? request()->routeIs($route) 
            : (request()->routeIs($route) || request()->routeIs($route . '.*'));
    } else if (config('app.debug')) {
        $url = "ROUTE_NOT_FOUND_" . strtoupper($route);
    }
@endphp

<a href="{{ $url }}"
    {{-- Dynamic Width & Center --}}
    :class="isCollapsed ? 'justify-center px-0 mx-auto w-12 h-12' : 'px-4 py-3 w-full'"
    class="group relative flex items-center rounded-xl text-sm font-medium transition-all duration-300 mb-2
    {{ $isActive
        ? 'bg-gradient-to-r from-primary-n5/15 to-secondary-n5/10 border border-primary-n5/25 text-primary-n5 shadow-sm shadow-primary-n5/5'
        : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/5 border border-transparent' }}"
    :title="isCollapsed ? '{{ $label }}' : ''">

    {{-- Garis Indikator Samping --}}
    @if($isActive)
    <div :class="isCollapsed ? 'left-0 w-1' : 'left-0 w-1.5'"
         class="absolute top-1/2 -translate-y-1/2 h-8 bg-gradient-to-b from-primary-n5 to-secondary-n5 rounded-r-full shadow-[0_0_10px_rgba(0,74,173,0.3)] transition-all">
    </div>
    @endif

    {{-- Icon Wrapper --}}
    <div :class="isCollapsed ? 'mx-0' : 'mr-3'"
         class="flex-shrink-0 w-5 h-5 flex items-center justify-center transition-all duration-300 {{ $isActive ? 'scale-110 drop-shadow-[0_0_3px_rgba(0,74,173,0.3)]' : 'group-hover:scale-110' }}">
        @if($icon)
            {!! $icon !!}
        @else
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
        @endif
    </div>

    {{-- Label Teks --}}
    <span x-show="!isCollapsed" 
          x-transition:enter="transition ease-out duration-200"
          x-transition:enter-start="opacity-0 -translate-x-2"
          x-transition:enter-end="opacity-100 translate-x-0"
          class="flex-1 truncate font-semibold tracking-tight">
        {{ $label }}
    </span>
    
    {{-- Active Dot/Indicator --}}
    @if($isActive)
    <div x-show="!isCollapsed" class="ml-2 w-1.5 h-1.5 rounded-full bg-primary-n5 animate-pulse"></div>
    @endif

    {{-- Floating Tooltip --}}
    <div x-show="isCollapsed" 
         class="absolute left-full ml-4 px-3 py-1.5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-xs font-bold rounded-lg opacity-0 group-hover:opacity-100 pointer-events-none transition-all duration-200 whitespace-nowrap z-50 shadow-xl translate-x-2 group-hover:translate-x-0">
        {{ $label }}
        {{-- Arrow Tooltip --}}
        <div class="absolute right-full top-1/2 -translate-y-1/2 border-8 border-transparent border-r-slate-900 dark:border-r-white"></div>
    </div>
</a>