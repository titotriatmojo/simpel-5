@props(['collapsed' => false])

<div class="space-y-1">
    <div class="mt-5"></div>

    <x-sidebar-link route="guru.dashboard" label="Home" :collapsed="$collapsed" icon='<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="text-black dark:text-white" viewBox="0 0 32 32" id="home"><path d="M24.375,31L7.625,31C5.971,31 4.625,29.654 4.625,28L4.625,17L2,17C1.596,17 1.23,16.756 1.076,16.383C0.921,16.009 1.007,15.579 1.293,15.293L15.293,1.293C15.684,0.902 16.316,0.902 16.707,1.293L30.707,15.293C30.993,15.579 31.079,16.009 30.924,16.383C30.769,16.756 30.404,17 30,17L27.375,17L27.375,28C27.375,29.654 26.029,31 24.375,31ZM20.404,29L24.375,29C24.927,29 25.375,28.551 25.375,28L25.375,16C25.375,15.448 25.822,15 26.375,15L27.586,15L16,3.414L4.414,15L5.625,15C6.178,15 6.625,15.448 6.625,16L6.625,28C6.625,28.551 7.073,29 7.625,29L11.597,29L11.597,22.607C11.597,20.179 13.573,18.204 16,18.204C18.428,18.204 20.404,20.179 20.404,22.607L20.404,29ZM18.404,29L18.404,22.607C18.404,21.282 17.326,20.204 16,20.204C14.675,20.204 13.597,21.282 13.597,22.607L13.597,29L18.404,29Z"/></svg>' />

    @if(!$collapsed)
    <div class="px-3 py-2 mt-6 mb-2">
        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data & Monitoring</p>
    </div>
    @else
    <div class="h-px bg-gray-200 dark:bg-white/10 my-4"></div>
    @endif

    <x-sidebar-link route="guru.monitoring.siswa" label="Monitoring Siswa" :collapsed="$collapsed" icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>' />
    <x-sidebar-link route="guru.instansi.index" label="Data Instansi" :collapsed="$collapsed" icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2-2H5a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>' />

    @if(!$collapsed)
    <div class="px-3 py-2 mt-6 mb-2">
        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Penilaian</p>
    </div>
    @else
    <div class="h-px bg-gray-200 dark:bg-white/10 my-4"></div>
    @endif

    <x-sidebar-link route="guru.nilai.index" label="Input Nilai PKL" :collapsed="$collapsed" icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2M12 12a4 4 0 110-8 4 4 0 010 8z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 20h16" /></svg>' />

    {{-- SECTION BARU: PREDIKSI SISWA (KNN) --}}
    @if(!$collapsed)
    <div class="px-3 py-2 mt-6 mb-2">
        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Prediksi Siswa</p>
    </div>
    @else
    <div class="h-px bg-gray-200 dark:bg-white/10 my-4"></div>
    @endif

    <x-sidebar-link route="guru.spk.index" label="Analisis SPK (KNN)" :collapsed="$collapsed" icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>' />

    @if(!$collapsed)
    <div class="px-3 py-2 mt-6 mb-2">
        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Profil</p>
    </div>
    @else
    <div class="h-px bg-gray-200 dark:bg-white/10 my-4"></div>
    @endif

    <x-sidebar-link route="profile.edit" label="Profil Saya" :collapsed="$collapsed" icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>' />
</div>