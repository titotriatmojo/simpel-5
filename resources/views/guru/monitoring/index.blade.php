<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        {{-- Header & Action Section --}}
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                        Monitoring Siswa PKL
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">
                        Pantau status pendaftaran dan penempatan siswa bimbingan secara real-time.
                    </p>
                </div>

                {{-- Action Buttons & Stats --}}
                <div class="flex flex-wrap items-center gap-4">
                    {{-- Tombol Export Excel - DISESUAIKAN --}}
                    <a href="{{ route('guru.monitoring.siswa', ['export' => 'excel']) }}"
                       class="inline-flex items-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-sm shadow-emerald-200 dark:shadow-none gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export Excel
                    </a>

                    <div class="h-10 w-px bg-gray-200 dark:bg-slate-700 hidden md:block"></div>

                    {{-- Mini Stat Cards --}}
                    <div class="flex gap-3">
                        <div class="bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-100 dark:border-emerald-500/20 px-4 py-2 rounded-xl">
                            <span class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest">Diterima</span>
                            <span class="text-lg font-black text-emerald-700 dark:text-emerald-400 leading-none">{{ $stats['diterima'] }}</span>
                        </div>
                        <div class="bg-amber-50 dark:bg-amber-500/10 border border-amber-100 dark:border-amber-500/20 px-4 py-2 rounded-xl">
                            <span class="block text-[10px] font-black text-amber-600 uppercase tracking-widest">Proses</span>
                            <span class="text-lg font-black text-amber-700 dark:text-amber-400 leading-none">{{ $stats['menunggu'] }}</span>
                        </div>
                        <div class="bg-rose-50 dark:bg-rose-500/10 border border-rose-100 dark:border-rose-500/20 px-4 py-2 rounded-xl">
                            <span class="block text-[10px] font-black text-rose-600 uppercase tracking-widest">Ditolak</span>
                            <span class="text-lg font-black text-rose-700 dark:text-rose-400 leading-none">{{ $stats['ditolak'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-6 w-full h-px bg-gradient-to-r from-indigo-500 to-transparent opacity-20"></div>
        </div>

        {{-- Table Container --}}
        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-3xl overflow-hidden shadow-sm shadow-indigo-100/50">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-slate-900/50 border-b border-gray-100 dark:border-slate-700">
                            <th class="px-6 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-widest text-center w-20">No</th>
                            <th class="px-6 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-widest">Informasi Siswa</th>
                            <th class="px-6 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-widest">Kelas & Jurusan</th>
                            <th class="px-6 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-widest">Instansi Tujuan</th>
                            <th class="px-6 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-widest text-center">Status</th>
                            <th class="px-6 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-widest text-center">Laporan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-slate-700/50">
                        @forelse($siswa as $index => $item)
                        <tr class="hover:bg-indigo-50/30 dark:hover:bg-indigo-500/5 transition-colors group">
                            {{-- Nomor --}}
                            <td class="px-6 py-6 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-slate-700 text-xs font-bold text-gray-500 dark:text-slate-400">
                                    {{ $index + 1 }}
                                </span>
                            </td>

                            {{-- Nama & NISN --}}
                            <td class="px-6 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-sm shadow-md shadow-indigo-200 dark:shadow-none">
                                        {{ substr($item->nama, 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 transition-colors capitalize">
                                            {{ $item->nama }}
                                        </span>
                                        <span class="text-[11px] text-gray-400 font-medium">NISN: {{ $item->nim }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- Kelas & Jurusan --}}
                            <td class="px-6 py-6">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-gray-700 dark:text-slate-300">{{ $item->kelas }}</span>
                                    <span class="text-[10px] text-gray-400 uppercase font-medium tracking-tight">{{ $item->program_studi }}</span>
                                </div>
                            </td>

                            {{-- Instansi --}}
                            <td class="px-6 py-6">
                                @if($item->pendaftaranPkl && $item->pendaftaranPkl->perusahaan)
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-indigo-50 dark:bg-indigo-500/10 rounded-xl">
                                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-slate-200">
                                            {{ $item->pendaftaranPkl->perusahaan->nama }}
                                        </span>
                                    </div>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-medium bg-gray-100 text-gray-400 dark:bg-slate-700 dark:text-slate-500 uppercase tracking-tighter italic">
                                        Belum Terdaftar
                                    </span>
                                @endif
                            </td>

                            {{-- Status Badge --}}
                            <td class="px-6 py-6 text-center">
                                @php
                                    $status = $item->pendaftaranPkl->status ?? 'belum';
                                    $badges = [
                                        'menunggu' => 'bg-amber-100 text-amber-700 border-amber-200 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20',
                                        'diterima' => 'bg-emerald-100 text-emerald-700 border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20',
                                        'ditolak'  => 'bg-rose-100 text-rose-700 border-rose-200 dark:bg-rose-500/10 dark:text-rose-400 dark:border-rose-500/20',
                                        'belum'    => 'bg-gray-100 text-gray-500 border-gray-200 dark:bg-slate-700 dark:text-slate-500 dark:border-slate-600',
                                    ];
                                    $style = $badges[$status] ?? $badges['belum'];
                                @endphp
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $style }}">
                                    @if($status !== 'belum')
                                        <span class="w-1.5 h-1.5 rounded-full bg-current mr-2 opacity-75"></span>
                                    @endif
                                    {{ $status }}
                                </span>
                            </td>
                            {{-- Kolom Laporan --}}
                            <td class="px-6 py-6">    
                                        {{-- Tombol Download (Kolom 'file') --}}
                                        @if($item->laporanPkl && $item->laporanPkl->file)
                                            <a href="{{ route('guru.laporan.download', $item->laporanPkl->id) }}"
                                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-800">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                </svg>
                                                Download PDF/DOC
                                            </a>
                                        @else
                                            <span class="text-[10px] text-gray-400 italic font-medium uppercase tracking-tighter">File Kosong</span>
                                        @endif

                                        {{-- Link Drive (Kolom 'link_drive') --}}
                                        @if($item->laporanPkl && $item->laporanPkl->link_drive)
                                            <a href="{{ $item->laporanPkl->link_drive }}" 
                                            target="_blank" 
                                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-800">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                </svg>
                                                Link Google Drive
                                            </a>
                                        @else
                                            <span class="text-[10px] text-gray-400 italic font-medium uppercase tracking-tighter text-rose-400">Drive Tidak Ada</span>
                                        @endif

                                    </div>
                                </div>
                            </td>

                            
                        </tr>


                         {{-- kalau kosong --}}
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-32 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-gray-50 dark:bg-slate-900/50 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Tidak Ada Siswa</h3>
                                    <p class="text-xs text-gray-400 mt-1 max-w-[200px] mx-auto">Anda belum memiliki siswa bimbingan yang terdaftar dalam sistem monitoring.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>