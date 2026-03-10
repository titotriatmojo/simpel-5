<x-app-layout>
    {{-- Header --}}
    <div class="mb-8">
        <a href="{{ route('guru.spk.index') }}" class="inline-flex items-center text-sm text-blue-500 hover:text-blue-600 mb-4 font-medium transition-colors group">
            <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Analisis
        </a>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Data Training Alumni</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Kelola dataset referensi untuk perhitungan algoritma KNN.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Form Input Manual --}}
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-white/10 rounded-2xl p-6 shadow-sm sticky top-8">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <span class="w-2 h-6 bg-blue-500 rounded-full mr-3"></span>
                    Tambah Data Alumni
                </h2>
                
                <form action="{{ route('guru.spk.training.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2 ml-1">Nama Alumni</label>
                        <input type="text" name="nama" placeholder="Contoh: Budi Santoso" class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all dark:text-white">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2 ml-1">Akademik</label>
                            <input type="number" name="nilai_akademik" step="0.01" min="0" max="100" required placeholder="0-100" class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm outline-none transition-all focus:ring-2 focus:ring-blue-500 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2 ml-1">Instansi</label>
                            <input type="number" name="nilai_instansi" step="0.01" min="0" max="100" required placeholder="0-100" class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm outline-none transition-all focus:ring-2 focus:ring-blue-500 dark:text-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2 ml-1">Nilai Pembimbing</label>
                        <input type="number" name="nilai_pembimbing" step="0.01" min="0" max="100" required placeholder="0-100" class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm outline-none transition-all focus:ring-2 focus:ring-blue-500 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2 ml-1">Label (Status Kerja)</label>
                        <select name="label" required class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm outline-none transition-all focus:ring-2 focus:ring-blue-500 dark:text-white">
                            <option value="Siap">SIAP KERJA</option>
                            <option value="Tidak Siap">TIDAK SIAP</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transition-all mt-4 flex justify-center items-center group">
                        Simpan Data
                        <svg class="w-4 h-4 ml-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </button>
                </form>
            </div>
        </div>

        {{-- Tabel Dataset --}}
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-white/10 rounded-2xl p-6 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Dataset Referensi ({{ $trainingData->count() }})</h2>
                    <span class="text-xs bg-gray-100 dark:bg-white/5 text-gray-500 px-3 py-1 rounded-full font-medium italic">KNN Data Source</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-white/5 text-gray-400 text-[10px] uppercase tracking-widest">
                                <th class="px-4 py-3 font-semibold">Nama Alumni</th>
                                <th class="px-2 py-3 text-center font-semibold">Akad</th>
                                <th class="px-2 py-3 text-center font-semibold">Inst</th>
                                <th class="px-2 py-3 text-center font-semibold">Pemb</th>
                                <th class="px-4 py-3 text-center font-semibold">Label</th>
                                <th class="px-4 py-3 text-right font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-white/5 text-gray-900 dark:text-white">
                            @forelse($trainingData as $data)
                            <tr class="text-sm hover:bg-gray-50 dark:hover:bg-white/5 transition-colors group">
                                <td class="px-4 py-4">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $data->nama ?? 'Anonim' }}</div>
                                    <div class="text-[10px] text-gray-400">ID: #TRN-{{ str_pad($data->id, 3, '0', STR_PAD_LEFT) }}</div>
                                </td>
                                <td class="px-2 py-4 text-center font-mono text-xs">{{ $data->nilai_akademik }}</td>
                                <td class="px-2 py-4 text-center font-mono text-xs">{{ $data->nilai_instansi }}</td>
                                <td class="px-2 py-4 text-center font-mono text-xs">{{ $data->nilai_pembimbing }}</td>
                                <td class="px-4 py-4 text-center">
                                    @if($data->label == 'Siap')
                                        <span class="px-3 py-1 bg-green-500/10 text-green-500 rounded-full text-[9px] font-black uppercase tracking-tighter border border-green-500/20">SIAP</span>
                                    @else
                                        <span class="px-3 py-1 bg-red-500/10 text-red-500 rounded-full text-[9px] font-black uppercase tracking-tighter border border-red-500/20">TIDAK</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-right">
                                    {{-- FIX: Action Hapus diarahkan ke rute yang benar --}}
                                    <form action="{{ route('guru.spk.training.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Hapus data alumni ini dari dataset?')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-500/10">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                        <p class="text-gray-500 text-sm">Dataset masih kosong.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>