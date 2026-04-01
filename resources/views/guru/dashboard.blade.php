<x-app-layout>
    {{-- Main Dashboard Content --}}
    <div class="max-w-7xl mx-auto space-y-6 px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Welcome Hero Section --}}
        <div class="relative overflow-hidden bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-3xl p-8 shadow-sm">
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-secondary-n5/10 rounded-full blur-3xl"></div>
            
            <div class="relative flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex-1 space-y-4 text-center md:text-left">
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-primary-n5/10 text-primary-n5 text-xs font-bold tracking-wider uppercase">
                        Dashboard Guru
                    </div>
                    <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white leading-tight">
                        Selamat Datang, <br>
                        <span class="bg-gradient-to-r from-primary-n5 to-secondary-n5 bg-clip-text text-transparent">
                            {{ $guru->nama }}!
                        </span>
                    </h1>
                    <p class="text-gray-500 dark:text-slate-400 text-lg max-w-xl">
                        Akses pusat informasi dan monitoring untuk mendukung keberhasilan Praktik Kerja Lapangan siswa bimbingan Anda.
                    </p>
                    
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-6 pt-2">
                        <div class="flex items-center text-gray-600 dark:text-slate-300">
                            <div class="p-2 bg-gray-100 dark:bg-slate-800 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-primary-n5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <span class="font-medium text-sm">{{ \Carbon\Carbon::now()->translatedFormat('l, j F Y') }}</span>
                        </div>
                        <div class="flex items-center text-gray-600 dark:text-slate-300">
                            <div class="p-2 bg-gray-100 dark:bg-slate-800 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-secondary-n5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <span class="font-medium text-sm"><span id="clock"></span> WIB</span>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-primary-n5 to-secondary-n5 rounded-full blur-2xl opacity-15"></div>
                    <img src="/intern-op-01.png" alt="Internship Illustration" class="relative w-44 h-44 md:w-52 md:h-52 object-contain dark:hidden transform hover:scale-105 transition-transform duration-500">
                    <img src="/intern-op-01.png" alt="Internship Illustration" class="relative hidden dark:block w-44 h-44 md:w-52 md:h-52 object-contain transform hover:scale-105 transition-transform duration-500">
                </div>
            </div>
        </div>

        {{-- Stats & Information Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Info Profil Card --}}
            <div class="lg:col-span-1 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-3xl p-8 flex flex-col justify-center items-center text-center shadow-sm relative overflow-hidden">
                <div class="absolute top-0 left-0 w-2 h-full bg-primary-n5"></div>
                <div class="p-4 bg-primary-n5/10 rounded-2xl text-primary-n5 mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h3 class="text-gray-500 dark:text-slate-400 text-sm font-bold uppercase tracking-widest">NIP Pembimbing</h3>
                <span class="text-2xl font-black text-gray-900 dark:text-white my-2">{{ $guru->nip }}</span>
                <p class="text-primary-n5 text-sm font-semibold">{{ $guru->program_studi }}</p>
            </div>

            {{-- Information & Tips Section --}}
            <div class="lg:col-span-2 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-3xl p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-secondary-n5/10 rounded-lg text-secondary-n5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Informasi Sistem</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700/50">
                        <h4 class="text-primary-n5 font-bold text-sm flex items-center gap-2 mb-2">
                            <span>💡</span> Navigasi
                        </h4>
                        <p class="text-gray-600 dark:text-slate-400 text-sm leading-relaxed">
                            Gunakan menu di samping untuk mengelola data siswa, memverifikasi jurnal, dan melihat laporan PKL.
                        </p>
                    </div>
                    
                    <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700/50">
                        <h4 class="text-secondary-n5 font-bold text-sm flex items-center gap-2 mb-2">
                            <span>📢</span> Status Data
                        </h4>
                        <p class="text-gray-600 dark:text-slate-400 text-sm leading-relaxed">
                            Data bimbingan sedang disinkronisasi. Silakan hubungi admin jika terdapat ketidaksesuaian data.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
        function updateClock() {
            const now = new Date();
            // Ambil waktu UTC
            const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
            
            // Ubah offset ke +7 untuk WIB
            const wib = new Date(utc + (7 * 60 * 60 * 1000));
            
            document.getElementById('clock').textContent = wib.toLocaleTimeString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit', 
                hour12: false 
            });
        }
        updateClock();
        setInterval(updateClock, 1000);
    </script>
</x-app-layout>