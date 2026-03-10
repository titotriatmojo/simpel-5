<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        {{-- Header Section --}}
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                        Direktori Mitra Industri
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">
                        Daftar instansi terverifikasi dan pemantauan jumlah siswa di lokasi.
                    </p>
                </div>
                {{-- Badge Total --}}
                <div class="inline-flex items-center px-4 py-2 bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-100 dark:border-indigo-500/20 rounded-xl">
                    <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest mr-2">Total Mitra:</span>
                    <span class="text-lg font-black text-indigo-700 dark:text-indigo-300">{{ $instansi->count() }}</span>
                </div>
            </div>
            <div class="mt-4 w-24 h-1.5 bg-indigo-600 rounded-full"></div>
        </div>

        {{-- Main Content --}}
        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-3xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse border-spacing-0">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-slate-900/50 border-b border-gray-100 dark:border-slate-700">
                            <th class="px-6 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-widest text-center w-16">No</th>
                            <th class="px-6 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-widest">Informasi Instansi</th>
                            <th class="px-6 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-widest">Kontak</th>
                            <th class="px-6 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-widest text-center">Siswa Aktif</th>
                            <th class="px-6 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-widest">Alamat Lokasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($instansi as $index => $item)
                        <tr class="hover:bg-indigo-50/30 dark:hover:bg-indigo-500/5 transition-colors group">
                            {{-- Nomor --}}
                            <td class="px-6 py-6 text-center">
                                <span class="text-sm font-mono text-gray-400">
                                    {{ $index + 1 }}
                                </span>
                            </td>

                            {{-- Nama Instansi --}}
                            <td class="px-6 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 rounded-xl flex items-center justify-center font-bold text-lg group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                                        {{ substr($item->nama, 0, 1) }}
                                    </div>
                                    <div class="text-sm font-bold text-gray-900 dark:text-white leading-tight">
                                        {{ $item->nama }}
                                    </div>
                                </div>
                            </td>

                            {{-- Kontak (Fix no_hp) --}}
                            <td class="px-6 py-6">
                                <div class="flex flex-col gap-1.5">
                                    <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-slate-300">
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        {{ $item->email ?? '-' }}
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-slate-300">
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        {{ $item->no_hp ?? '-' }}
                                    </div>
                                </div>
                            </td>

                            {{-- Jumlah Siswa --}}
                            <td class="px-6 py-6 text-center">
                                <div class="inline-flex flex-col items-center">
                                    <span class="text-lg font-black text-indigo-600 dark:text-indigo-400">
                                        {{ $item->siswas_count ?? 0 }}
                                    </span>
                                    <span class="text-[9px] text-gray-400 uppercase font-bold tracking-tighter">Siswa</span>
                                </div>
                            </td>

                            {{-- Alamat (Icon Map) --}}
                            <td class="px-6 py-6">
                                <div class="flex items-start gap-2 max-w-xs">
                                    <svg class="w-4 h-4 text-grey-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <p class="text-xs text-gray-500 dark:text-slate-400 leading-relaxed ">
                                        {{ $item->alamat }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center text-gray-400 italic">
                                Belum ada data instansi yang tersedia.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>