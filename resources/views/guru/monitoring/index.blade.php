<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        {{-- Header & Statistik --}}
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                        Monitoring Siswa PKL
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">
                        Pantau status pendaftaran dan penempatan siswa secara real-time.
                    </p>
                </div>
                
                {{-- Stat Cards --}}
                <div class="flex gap-4">
                    <div class="bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-100 dark:border-emerald-500/20 px-4 py-2 rounded-xl text-center">
                        <span class="block text-xs font-bold text-emerald-600 uppercase">Diterima</span>
                        <span class="text-xl font-black text-emerald-700 dark:text-emerald-400">{{ $siswa->where('pendaftaranPkl.status', 'diterima')->count() }}</span>
                    </div>
                    <div class="bg-amber-50 dark:bg-amber-500/10 border border-amber-100 dark:border-amber-500/20 px-4 py-2 rounded-xl text-center">
                        <span class="block text-xs font-bold text-amber-600 uppercase">Proses</span>
                        <span class="text-xl font-black text-amber-700 dark:text-amber-400">{{ $siswa->where('pendaftaranPkl.status', 'menunggu')->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 w-24 h-1.5 bg-indigo-600 rounded-full"></div>
        </div>

        {{-- Table Container --}}
        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-3xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-slate-900/50 border-b border-gray-100 dark:border-slate-700">
                            <th class="px-6 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-widest text-center w-16">No</th>
                            <th class="px-6 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-widest">Informasi Siswa</th>
                            <th class="px-6 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-widest">Kelas & Jurusan</th>
                            <th class="px-6 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-widest">Instansi Tujuan</th>
                            <th class="px-6 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-widest text-center">Status Pendaftaran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($siswa as $index => $item)
                        <tr class="hover:bg-indigo-50/30 dark:hover:bg-indigo-500/5 transition-colors group">
                            {{-- Nomor --}}
                            <td class="px-6 py-6 text-center text-sm font-mono text-gray-400">
                                {{ $index + 1 }}
                            </td>

                            {{-- Nama & NIM --}}
                            <td class="px-6 py-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 transition-colors">
                                        {{ $item->nama }}
                                    </span>
                                    <span class="text-[11px] text-gray-500 font-medium">NIM: {{ $item->nim }}</span>
                                </div>
                            </td>

                            {{-- Kelas & Jurusan --}}
                            <td class="px-6 py-6">
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-gray-700 dark:text-slate-300">{{ $item->kelas }}</span>
                                    <span class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ $item->program_studi }}</span>
                                </div>
                            </td>

                            {{-- Instansi --}}
                            <td class="px-6 py-6">
                                @if($item->pendaftaranPkl && $item->pendaftaranPkl->perusahaan)
                                    <div class="flex items-center gap-2">
                                        <div class="p-1.5 bg-gray-100 dark:bg-slate-700 rounded-lg">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700 dark:text-slate-200">
                                            {{ $item->pendaftaranPkl->perusahaan->nama }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-xs italic text-gray-400">Belum mendaftar</span>
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
                                        'belum'    => 'bg-gray-100 text-gray-600 border-gray-200 dark:bg-slate-700 dark:text-slate-400 dark:border-slate-600',
                                    ];
                                    $badgeStyle = $badges[$status] ?? $badges['belum'];
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $badgeStyle }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current mr-1.5 animate-pulse"></span>
                                    {{ $status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <p class="text-gray-400 italic">Data siswa tidak ditemukan.</p>
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