<x-app-layout>
    {{-- Main Dashboard Content --}}
    <div class="max-w-7xl mx-auto space-y-6 px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Welcome Hero Section --}}
        <div class="relative overflow-hidden bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-3xl p-8 shadow-sm">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-primary-n5/10 rounded-full blur-3xl"></div>
            
            <div class="relative flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex-1 space-y-4">
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-primary-n5/10 text-primary-n5 text-xs font-semibold tracking-wide uppercase">
                        Dashboard Siswa 
                    </div>
                    <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white leading-tight">
                        Selamat Datang, <br>
                        <span class="bg-gradient-to-r from-primary-n5 to-secondary-n5 bg-clip-text text-transparent">
                            {{ Auth::user()->siswa->nama ?? Auth::user()->name }}!
                        </span>
                    </h1>
                    <p class="text-gray-500 dark:text-slate-400 text-lg max-w-xl">
                        Pantau status pendaftaran dan kelola dokumen Praktik Kerja Lapangan Anda dalam satu platform terintegrasi.
                    </p>
                    
                    <div class="flex flex-wrap items-center gap-6 pt-2">
                        <div class="flex items-center text-gray-600 dark:text-slate-300">
                            <div class="p-2 bg-gray-100 dark:bg-slate-800 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-primary-n5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <span class="font-medium">{{ \Carbon\Carbon::now()->translatedFormat('l, j F Y') }}</span>
                        </div>
                        <div class="flex items-center text-gray-600 dark:text-slate-300">
                            <div class="p-2 bg-gray-100 dark:bg-slate-800 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-secondary-n5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <span class="font-medium"><span id="clock"></span> WIB</span>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-primary-n5 to-secondary-n5 rounded-full blur-2xl opacity-15"></div>
                    <img src="/intern-op-01.png" alt="Internship Illustration" class="relative w-48 h-48 md:w-56 md:h-56 object-contain transform hover:rotate-3 transition-transform duration-500 shadow-sm dark:hidden">
                    <img src="/intern-op-01.png" alt="Internship Illustration" class="relative hidden dark:block w-48 h-48 md:w-56 md:h-56 object-contain transform hover:rotate-3 transition-transform duration-500">
                </div>
            </div>
        </div>

        {{-- Utama Section: Stats & Information --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Status Pendaftaran - Card --}}
            @php $pendaftaran = Auth::user()->siswa->pendaftaranPkl()->latest()->first(); @endphp
            <div class="lg:col-span-2 group bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-3xl p-6 hover:shadow-xl hover:shadow-primary-n5/5 transition-all duration-300">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Status Pendaftaran PKL</h3>
                        <p class="text-sm text-gray-500">Informasi penempatan dan verifikasi instansi</p>
                    </div>
                    @if($pendaftaran)
                        <span class="px-4 py-1.5 rounded-full text-xs font-bold tracking-wide uppercase 
                            {{ $pendaftaran->status === 'diterima' ? 'bg-emerald-100 text-emerald-700' : ($pendaftaran->status === 'ditolak' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">
                            {{ $pendaftaran->status }}
                        </span>
                    @endif
                </div>

                @if($pendaftaran)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 rounded-2xl bg-gray-50 dark:bg-slate-800/50 border border-gray-100 dark:border-slate-700">
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">Bidang Keahlian</p>
                            <p class="text-gray-900 dark:text-white font-semibold">{{ $pendaftaran->bidang_pkl }}</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-gray-50 dark:bg-slate-800/50 border border-gray-100 dark:border-slate-700">
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">Periode Praktik</p>
                            <p class="text-gray-900 dark:text-white font-semibold">{{ $pendaftaran->periode }}</p>
                        </div>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-8 text-center">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4 text-gray-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-gray-500 mb-4">Anda belum mengajukan pendaftaran PKL.</p>
                        <a href="{{ route('siswa.pendaftaran.create') }}" class="px-6 py-2 bg-gradient-to-r from-primary-n5 to-secondary-n5 text-white font-bold rounded-xl shadow-lg shadow-primary-n5/20 hover:scale-105 transition-transform">
                            Daftar Sekarang
                        </a>
                    </div>
                @endif
            </div>

            {{-- Status Laporan - Card --}}
            @php $laporan = Auth::user()->siswa->laporanPkl()->latest()->first(); @endphp
            <div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-3xl p-6 flex flex-col justify-between">
                <div>
                    <div class="p-3 bg-secondary-n5/10 rounded-2xl w-fit mb-4 text-secondary-n5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Laporan PKL</h3>
                    <p class="text-sm text-gray-500 mb-6">Status pengunggahan laporan akhir digital.</p>
                </div>

                <div class="space-y-4">
                    @if($laporan)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-slate-800">
                            <span class="text-sm font-medium dark:text-white">File Laporan</span>
                            <a href="{{ asset('storage/' . $laporan->file) }}" target="_blank" class="text-primary-n5 hover:underline text-sm font-bold">Buka PDF</a>
                        </div>
                        <div class="flex items-center gap-2">
                             <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-secondary-n5" style="width: {{ $laporan->status === 'diterima' ? '100%' : '50%' }}"></div>
                             </div>
                             <span class="text-[10px] font-bold uppercase text-secondary-n5">{{ $laporan->status }}</span>
                        </div>
                    @else
                        <div class="text-center p-4 border-2 border-dashed border-gray-200 dark:border-slate-800 rounded-2xl">
                            <p class="text-xs text-gray-400 italic">Belum ada file yang diunggah</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Info & Tips Section --}}
        <div class="bg-gradient-to-br from-primary-n5 to-secondary-n5 rounded-3xl p-8 text-white">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <div class="hidden md:block p-4 bg-white/20 rounded-2xl backdrop-blur-md">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-2xl font-bold mb-2">Pemberitahuan Penting</h3>
                    <p class="text-white/80 leading-relaxed">
                        Seluruh siswa wajib mengunggah Laporan PKL paling lambat <span class="font-bold">7 hari</span> setelah masa praktik berakhir. Pastikan logbook harian Anda sudah disetujui oleh pembimbing instansi sebelum melakukan finalisasi laporan.
                    </p>
                </div>
                <div class="w-full md:w-auto">
                    <button class="w-full px-8 py-3 bg-white text-primary-n5 font-extrabold rounded-xl hover:bg-gray-100 transition-colors shadow-lg">
                        Lihat Panduan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    function updateClock() {
        const now = new Date();
        const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
        // Ganti jadi +7 untuk WIB (Waktu Indonesia Barat)
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