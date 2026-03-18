<div class="flex flex-col h-full space-y-1 px-3 bg-white dark:bg-gray-900 transition-all duration-300">
    <div class="flex flex-col h-full space-y-1 bg-white dark:bg-gray-900 transition-all duration-300">
    {{-- Spacer Atas --}}
    <div class="mt-5"></div>

    {{-- Menu Utama --}}
    <div class="flex-1 space-y-1 overflow-y-auto overflow-x-hidden custom-scrollbar">
        <x-sidebar-link route="guru.dashboard" 
            label="Home" 
            ::collapsed="isCollapsed" 
            icon='<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5" viewBox="0 0 32 32"><path d="M24.375,31L7.625,31C5.971,31 4.625,29.654 4.625,28L4.625,17L2,17C1.596,17 1.23,16.756 1.076,16.383C0.921,16.009 1.007,15.579 1.293,15.293L15.293,1.293C15.684,0.902 16.316,0.902 16.707,1.293L30.707,15.293C30.993,15.579 31.079,16.009 30.924,16.383C30.769,16.756 30.404,17 30,17L27.375,17L27.375,28C27.375,29.654 26.029,31 24.375,31ZM20.404,29L24.375,29C24.927,29 25.375,28.551 25.375,28L25.375,16C25.375,15.448 25.822,15 26.375,15L27.586,15L16,3.414L4.414,15L5.625,15C6.178,15 6.625,15.448 6.625,16L6.625,28C6.625,28.551 7.073,29 7.625,29L11.597,29L11.597,22.607C11.597,20.179 13.573,18.204 16,18.204C18.428,18.204 20.404,20.179 20.404,22.607L20.404,29ZM18.404,29L18.404,22.607C18.404,21.282 17.326,20.204 16,20.204C14.675,20.204 13.597,21.282 13.597,22.607L13.597,29L18.404,29Z"/></svg>' 
        />

        {{-- SECTION: MONITORING --}}
        <div class="pt-4 pb-1">
            <template x-if="!isCollapsed">
                <p class="px-3 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest hidden md:block transition-opacity duration-300">Data & Monitoring</p>
            </template>
            <div x-show="isCollapsed || mobileOpen" class="h-px bg-gray-100 dark:bg-white/5 mx-2 md:my-2"></div>
        </div>
        <x-sidebar-link route="guru.monitoring.siswa" label="Monitoring Siswa" ::collapsed="isCollapsed" icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>' />
        <x-sidebar-link route="guru.instansi.index" label="Data Instansi" ::collapsed="isCollapsed" icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2-2H5a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>' />

        {{-- SECTION: PENILAIAN --}}
        <div class="pt-4 pb-1">
            <template x-if="!isCollapsed">
                <p class="px-3 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest hidden md:block transition-opacity duration-300">Penilaian</p>
            </template>
            <div x-show="isCollapsed" class="h-px bg-gray-100 dark:bg-white/5 mx-2 md:my-2"></div>
        </div>
        <x-sidebar-link route="guru.nilai.index" label="Input Nilai PKL" ::collapsed="isCollapsed" icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2M12 12a4 4 0 110-8 4 4 0 010 8z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 20h16" /></svg>' />

        {{-- SECTION: SPK --}}
        <div class="pt-4 pb-1">
            <template x-if="!isCollapsed">
                <p class="px-3 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest hidden md:block">Prediksi Siswa</p>
            </template>
            <div x-show="isCollapsed" class="h-px bg-gray-100 dark:bg-white/5 mx-2 md:my-2"></div>
        </div>
        <x-sidebar-link route="guru.spk.index" label="Analisis SPK (KNN)" ::collapsed="isCollapsed" icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>' />

        {{-- SECTION: PROFIL --}}
        <div class="pt-4 pb-1">
            <template x-if="!isCollapsed">
                <p class="px-3 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest hidden md:block">Akun</p>
            </template>
            <div x-show="isCollapsed" class="h-px bg-gray-100 dark:bg-white/5 mx-2 md:my-2"></div>
        </div>
        <x-sidebar-link route="profile.edit" label="Profil Saya" ::collapsed="isCollapsed" icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>' />
    </div>

    {{-- FOOTER: HAMBURGER --}}
    <div class="pt-4 pb-6 border-t border-gray-100 dark:border-white/5">
        <button @click="isCollapsed = !isCollapsed" class="group flex items-center justify-center md:justify-start w-full px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg transition-all">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <span x-show="!isCollapsed" class="ml-3 truncate">Sembunyikan</span>
        </button>
    </div>
</div>