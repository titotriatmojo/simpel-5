<x-app-layout>
    <div class="max-w-5xl mx-auto py-8 px-4">
        {{-- Breadcrumbs & Back Button --}}
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('siswa.perusahaan') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-primary-n5 dark:text-slate-400 dark:hover:text-primary-n5 transition-colors">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Daftar
            </a>
            <span class="text-xs bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 px-3 py-1 rounded-full font-bold uppercase tracking-wider">
                Mitra Terverifikasi
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Kolom Kiri: Profil Utama --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Card Nama Perusahaan --}}
                <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-2xl p-8 shadow-sm">
                    <div class="flex items-center gap-6 mb-6">
                        <div class="w-20 h-20 bg-primary-n5 rounded-2xl flex items-center justify-center text-white text-3xl font-bold shadow-lg shadow-primary-n5/20">
                            {{ substr($perusahaan->nama, 0, 1) }}
                        </div>
                        <div>
                            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">{{ $perusahaan->nama }}</h1>
                            
                            {{-- Link Lokasi Maps Ungu --}}
                            @if($perusahaan->koordinat_lokasi)
                                <a href="{{ str_contains($perusahaan->koordinat_lokasi, 'http') ? $perusahaan->koordinat_lokasi : 'https://www.google.com/maps/search/' . urlencode($perusahaan->koordinat_lokasi) }}" 
                                   target="_blank" 
                                   class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors group">
                                    <svg class="w-4 h-4 shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Lihat Lokasi Perusahaan di Google Maps
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    <div class="prose dark:prose-invert max-w-none border-t border-gray-100 dark:border-slate-700 pt-6">
                        <h3 class="text-lg font-bold mb-2 text-gray-900 dark:text-white">Bidang Perusahaan</h3>
                        <p class="text-gray-600 dark:text-slate-400 leading-relaxed text-sm">
                            Perusahaan ini bergerak di bidang <span class="font-semibold text-primary-n5 dark:text-white">{{ $perusahaan->bidang_usaha ?? 'Umum / Belum ditentukan' }}</span>.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Kontak & Informasi --}}
            <div class="space-y-6">
                <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-2xl p-6 shadow-sm">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6 text-center border-b border-gray-50 dark:border-slate-700 pb-2">Detail Kontak</h3>
                    
                    <ul class="space-y-6">
                        {{-- Alamat --}}
                        <li class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-gray-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase">Alamat Lengkap</p>
                                <p class="text-sm text-gray-700 dark:text-slate-200 leading-snug">
                                    {{ $perusahaan->alamat }}
                                </p>
                            </div>
                        </li>
                        
                        {{-- Nomor Telepon --}}
                        <li class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-gray-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase">Nomor Telepon</p>
                                <p class="text-sm text-gray-700 dark:text-slate-200 font-mono">{{ $perusahaan->no_hp }}</p>
                            </div>
                        </li>

                        {{-- Email Perusahaan --}}
                        <li class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-gray-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase">Email Perusahaan</p>
                                <p class="text-sm text-gray-700 dark:text-slate-200 break-all">{{ $perusahaan->email ?? 'Tidak tersedia' }}</p>
                            </div>
                        </li>
                    </ul>
                </div>

                {{-- Card Safety --}}
                <div class="bg-indigo-50 dark:bg-indigo-900/10 border border-indigo-200 dark:border-indigo-900/30 rounded-2xl p-6 shadow-sm">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-indigo-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <p class="text-xs text-indigo-800 dark:text-indigo-200 leading-relaxed font-semibold">
                            PENTING: Pastikan kamu sudah berkonsultasi dengan Guru Pembimbing atau Koordinator PKL sebelum mendatangi lokasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>