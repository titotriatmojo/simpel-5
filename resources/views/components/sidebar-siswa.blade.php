<div class="flex flex-col h-full bg-white dark:bg-gray-900 transition-all duration-300 px-3" x-cloak>
    {{-- Spacer Atas --}}
    <div class="mt-5"></div>

    {{-- Menu Utama (Admin) --}}
    <div class="flex-1 space-y-1 overflow-y-auto overflow-x-hidden custom-scrollbar">
        <x-sidebar-link route="admin.dashboard" label="Dashboard" ::collapsed="isCollapsed" 
            icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h2a2 2 0 012 2v6a2 2 0 01-2 2H10a2 2 0 01-2-2V5z" /></svg>' 
        />

        {{-- SECTION: MANAJEMEN PENGGUNA --}}
        <div class="pt-4 pb-1">
            <template x-if="!isCollapsed">
                <p class="px-3 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest hidden md:block transition-opacity duration-300">Manajemen Pengguna</p>
            </template>
            <div x-show="isCollapsed" class="h-px bg-gray-100 dark:bg-white/5 mx-2 md:my-2"></div>
        </div>
        <x-sidebar-link route="admin.siswa.index" label="Kelola Siswa" ::collapsed="isCollapsed" 
            icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 7a4 4 0 11-8 0 4 4 0 018 0zM21 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>' />
        <x-sidebar-link route="admin.guru.index" label="Kelola Guru" ::collapsed="isCollapsed" 
            icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 7a4 4 0 11-8 0 4 4 0 018 0zM21 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>' />

        {{-- SECTION: PERUSAHAAN --}}
        <div class="pt-4 pb-1">
            <template x-if="!isCollapsed">
                <p class="px-3 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest hidden md:block transition-opacity duration-300">Perusahaan</p>
            </template>
            <div x-show="isCollapsed" class="h-px bg-gray-100 dark:bg-white/5 mx-2 md:my-2"></div>
        </div>
        <x-sidebar-link route="admin.perusahaan.index" label="Kelola Perusahaan" ::collapsed="isCollapsed" 
            icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>' />

        {{-- SECTION: PENDAFTAR --}}
        <div class="pt-4 pb-1">
            <template x-if="!isCollapsed">
                <p class="px-3 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest hidden md:block transition-opacity duration-300">Pendaftar PKL</p>
            </template>
            <div x-show="isCollapsed" class="h-px bg-gray-100 dark:bg-white/5 mx-2 md:my-2"></div>
        </div>
        <x-sidebar-link route="admin.pendaftaran.index" label="Verifikasi PKL" ::collapsed="isCollapsed" 
            icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m1 10H6a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" /></svg>' />

        {{-- SECTION: LAPORAN --}}
        <div class="pt-4 pb-1">
            <template x-if="!isCollapsed">
                <p class="px-3 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest hidden md:block transition-opacity duration-300">Laporan PKL</p>
            </template>
            <div x-show="isCollapsed" class="h-px bg-gray-100 dark:bg-white/5 mx-2 md:my-2"></div>
        </div>
        <x-sidebar-link route="admin.laporan.verifikasi" label="Verifikasi Laporan" ::collapsed="isCollapsed" 
            icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m1 10H6a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" /></svg>' />
        <x-sidebar-link route="admin.format.index" label="Upload Format" ::collapsed="isCollapsed" 
            icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M16 12l-4-4m0 0l-4 4m4-4v12" /></svg>' />

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