<div class="flex flex-col h-full bg-white dark:bg-gray-900 transition-all duration-300 px-3" x-cloak>
    {{-- Spacer Atas --}}
    <div class="mt-5"></div>

    {{-- Menu Utama (siswa) --}}
    <div class="flex-1 space-y-1 overflow-y-auto overflow-x-hidden custom-scrollbar">
        <x-sidebar-link route="siswa.dashboard" label="Dashboard" ::collapsed="isCollapsed" 
            icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h2a2 2 0 012 2v6a2 2 0 01-2 2H10a2 2 0 01-2-2V5z" /></svg>' 
        />

        {{-- SECTION: MANAJEMEN PKL --}}
        <div class="pt-4 pb-1">
            <template x-if="!isCollapsed">
                <p class="px-3 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest hidden md:block transition-opacity duration-300">Manajemen PKL</p>
            </template>
            <div x-show="isCollapsed" class="h-px bg-gray-100 dark:bg-white/5 mx-2 md:my-2"></div>
        </div>
        <x-sidebar-link route="siswa.pendaftaran.index" label="Pendaftaran PKL" ::collapsed="isCollapsed" 
            icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>' />
        <x-sidebar-link route="siswa.perusahaan" label="List Perusahaan" ::collapsed="isCollapsed" 
            icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>' />

        {{-- SECTION: LAPORAN --}}
        <div class="pt-4 pb-1">
            <template x-if="!isCollapsed">
                <p class="px-3 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest hidden md:block transition-opacity duration-300">Laporan</p>
            </template>
            <div x-show="isCollapsed" class="h-px bg-gray-100 dark:bg-white/5 mx-2 md:my-2"></div>
        </div>
        <x-sidebar-link route="siswa.laporan.index" label="Upload Laporan PKL" ::collapsed="isCollapsed" 
            icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>' />
        <x-sidebar-link route="siswa.format" label="Format Laporan PKL" ::collapsed="isCollapsed" 
            icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>' />

        {{-- SECTION: AKUN --}}
        <div class="pt-4 pb-1">
            <template x-if="!isCollapsed">
                <p class="px-3 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest hidden md:block transition-opacity duration-300">Akun</p>
            </template>
            <div x-show="isCollapsed" class="h-px bg-gray-100 dark:bg-white/5 mx-2 md:my-2"></div>
        </div>
        <x-sidebar-link route="profile.edit" label="Profil Saya" ::collapsed="isCollapsed" 
            icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>' />
    </div>

    {{-- FOOTER: TOMBOL SEMBUNYIKAN --}}
    <div class="pt-4 pb-6 border-t border-gray-100 dark:border-white/5">
        <button @click="isCollapsed = !isCollapsed" class="group flex items-center justify-center md:justify-start w-full px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/10 rounded-lg transition-all">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <span x-show="!isCollapsed" class="ml-3 truncate">Sembunyikan</span>
        </button>
    </div>
</div>