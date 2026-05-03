<x-app-layout>
    {{-- Header --}}
    <div class="mb-8 bg-white dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-2xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2 tracking-tight">Analisis Kesiapan Kerja</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Prediksi kesiapan kerja siswa menggunakan metode <span class="text-primary-n5 dark:text-white font-semibold">K-Nearest Neighbor (KNN)</span>.</p>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Untuk Confusion Matrix: <a href="{{ route('guru.spk.testing.index') }}" class="text-primary-n5 dark:text-white font-semibold">Disini</a>
            </div>
            <div class="flex items-center gap-3">
                {{-- TOMBOL EXCEL BARU --}}
            <a href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}" class="flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-emerald-500/20 border border-emerald-500/30">
                <svg class="w-5 h-5 text-emerald-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export Hasil
            </a>
                <a href="{{ route('guru.spk.training.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-white/10 hover:bg-gray-200 dark:hover:bg-white/20 text-gray-900 dark:text-white text-sm font-semibold rounded-xl transition-all border border-gray-200 dark:border-white/10">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    Dataset Alumni
                </a>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-2xl overflow-hidden shadow-sm">
        <div class="p-6 border-b border-gray-200 dark:border-white/10 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Daftar Siswa Bimbingan</h2>
            <span class="text-xs font-medium text-gray-400 bg-gray-100 dark:bg-white/5 px-3 py-1 rounded-full">{{ $siswas->count() }} Total Siswa</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-white/[0.02] text-gray-500 dark:text-gray-400 text-[10px] uppercase tracking-[0.15em] font-black">
                        <th class="px-6 py-4 text-center">Aksi</th>
                        <th class="px-6 py-4">Siswa</th>
                        <th class="px-6 py-4 text-center border-x border-gray-200 dark:border-white/10">Nilai Instansi</th>
                        <th class="px-6 py-4 text-center border-r border-gray-200 dark:border-white/10">Nilai Sidang</th>
                        <th class="px-6 py-4 text-center">Nilai Total</th>
                        <th class="px-6 py-4 text-center">Hasil Prediksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-white/10 text-sm">
                    @foreach($siswas as $s)
                    <tr class="hover:bg-blue-500/[0.02] transition-colors group">
                        
                        {{-- Aksi --}}
                        <td class="px-6 py-4 text-center">
                            @if($s->nilai_pkl && $s->nilai_sidang && optional($s->nilaiPkl)->nilai)
                                <form action="{{ route('guru.spk.predict', $s->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="p-2.5 bg-primary-n5 hover:secondary-n5/20 text-white rounded-xl shadow-lg shadow-blue-500/20 transition-all active:scale-95 group-hover:scale-110">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                    </button>
                                </form>
                            @else
                                <button disabled class="p-2.5 bg-gray-200 dark:bg-white/10 text-gray-400 rounded-xl cursor-not-allowed opacity-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                </button>
                            @endif
                        </td>

                        {{-- Nama --}}
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-900 dark:text-white uppercase tracking-tight">{{ $s->name }}</span>
                                <span class="text-[10px] font-mono text-gray-500 dark:text-gray-400 tracking-wider">NISN: {{ $s->siswa->nim ?? 'N/A' }}</span>
                            </div>
                        </td>

                        {{-- NILAI PKL --}}
                        <td class="px-6 py-4 text-center border-x border-gray-200 dark:border-white/10">
                            <a href="{{ route('guru.spk.input', $s->id) }}" class="inline-block group-hover:scale-110 transition-transform">
                                @if($s->nilai_pkl)
                                    <span class="text-gray-900 dark:text-white font-mono font-bold text-base bg-blue-500/5 px-2 py-1 rounded-md border border-blue-500/10">{{ $s->nilai_pkl }}</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg border border-dashed border-gray-300 dark:border-white/20 text-gray-400 hover:text-blue-500 hover:border-blue-500 transition-all text-[10px] font-bold uppercase tracking-tighter">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg> Input
                                    </span>
                                @endif
                            </a>
                        </td>

                        {{-- NILAI SIDANG --}}
                        <td class="px-6 py-4 text-sm text-center">
                            @if(optional($s->nilaiPkl)->nilai)
                                <span class="text-gray-900 dark:text-white font-mono font-bold text-base bg-blue-500/5 px-2 py-1 rounded-md border border-blue-500/10">
                                    {{ number_format($s->nilaiPkl->nilai, 2) }}
                                </span>
                            @else
                                <span class="text-[10px] font-bold uppercase tracking-tighter text-gray-400 dark:text-gray-500 italic">Belum Dinilai</span>
                            @endif
                        </td>

                        {{-- TOTAL --}}
                        <td class="px-6 py-4 text-center border-r border-gray-200 dark:border-white/10">
                            <a class="inline-block group-hover:scale-110 transition-transform">
                                @php
                                    $pkl = $s->nilai_pkl ?? 0;
                                    $sidang = optional($s->nilaiPkl)->nilai ?? 0;
                                    $total = ($pkl && $sidang) ? ($pkl + $sidang) / 2 : null;
                                @endphp

                                @if($total)
                                    <span class="px-3 py-1 bg-primary-n5 text-white rounded-lg font-mono font-black shadow-sm">
                                        {{ number_format($total, 2) }}
                                    </span>
                                @else
                                    <span class="text-[10px] text-gray-400 italic">Belum Lengkap</span>
                                @endif
                            </a>
                        </td>

                        {{-- Prediksi --}}
                        <td class="px-6 py-4 text-center">
                            @if($s->hasil_prediksi)
                                <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $s->hasil_prediksi == 'Siap' ? 'bg-green-500/10 text-green-500 border border-green-500/20' : 'bg-red-500/10 text-red-500 border border-red-500/20' }}">
                                    {{ $s->hasil_prediksi }}
                                </span>
                            @else
                                <div class="flex items-center justify-center gap-2 text-gray-400">
                                    <div class="w-1.5 h-1.5 rounded-full bg-gray-300 dark:bg-white/20 animate-pulse"></div>
                                    <span class="text-[10px] font-bold uppercase italic">Belum Dianalisis</span>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>