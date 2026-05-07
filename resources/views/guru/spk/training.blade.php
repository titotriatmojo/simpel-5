<x-app-layout>
   {{-- Header --}}
<div class="mb-8 bg-white dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-2xl p-6 shadow-sm">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2 tracking-tight">Dataset Referensi (Alumni)</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Kelola data alumni yang digunakan sebagai dasar perhitungan <span class="text-primary-n5 dark:text-white font-semibold">K-Nearest Neighbor</span>.</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- TOMBOL HAPUS SEMUA (TRUNCATE) --}}
            @if($trainingData->count() > 0)
                <form action="{{ route('guru.spk.training.truncate') }}" method="POST" onsubmit="return confirm('Hapus seluruh dataset? Tindakan ini tidak bisa dibatalkan!')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20 text-red-600 dark:text-red-400 text-sm font-bold rounded-xl transition-all border border-red-200 dark:border-red-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Kosongkan Dataset
                    </button>
                </form>
            @endif

            <a href="{{ route('guru.spk.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-white/10 hover:bg-gray-200 dark:hover:bg-white/20 text-gray-900 dark:text-white text-sm font-semibold rounded-xl transition-all border border-gray-200 dark:border-white/10">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>
    </div>
</div>

        {{-- Action Buttons --}}
        <div class="flex items-center gap-3" x-data="{ openImport: false }">
            {{-- Tombol Export --}}
            <a href="{{ route('guru.spk.training.export') }}" class="flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-emerald-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export Excel
            </a>

            {{-- Tombol Import (Trigger Modal) --}}
            <button @click="openImport = true" class="flex items-center gap-2 px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-amber-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Import Excel
            </button>

            {{-- Modal Import --}}
            <div x-show="openImport" class="fixed inset-0 z-[50] overflow-y-auto" x-cloak>
                <div class="flex items-center justify-center min-h-screen px-4">
                    <div @click="openImport = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>
                    <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-2xl transform transition-all sm:max-w-lg sm:w-full border border-gray-200 dark:border-white/10">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Import Data Training</h3>
                                <button @click="openImport = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                            </div>
                            <form action="{{ route('guru.spk.training.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih File Excel (.xlsx)</label>
                                    <input type="file" name="file" accept=".xlsx, .xls" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-white/5 dark:file:text-white">
                                    <p class="mt-2 text-xs text-gray-500 italic">* Format kolom: Nama, Nilai PKL, Nilai Sidang, Nilai Total, Label (Siap/Tidak Siap)</p>
                                </div>
                                <div class="flex justify-end gap-3">
                                    <button type="button" @click="openImport = false" class="px-4 py-2 text-sm font-bold text-gray-500 hover:text-gray-700">Batal</button>
                                    <button type="submit" class="px-6 py-2 bg-primary-n5 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/20">Mulai Upload</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Form Input Manual (KONTEN TETAP SAMA SEPERTI MILIK USER) --}}
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-white/10 rounded-2xl p-6 shadow-sm sticky top-8">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <span class="w-2 h-6 bg-primary-n5 rounded-full mr-3"></span>
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
                            <label class="block text-[10px] font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2 ml-1">Nilai PKL</label>
                            <input type="number" name="nilai_pkl" step="0.01" min="0" max="100" required placeholder="0-100" class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm outline-none transition-all focus:ring-2 focus:ring-blue-500 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2 ml-1">Nilai Sidang</label>
                            <input type="number" name="nilai_sidang" step="0.01" min="0" max="100" required placeholder="0-100" class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm outline-none transition-all focus:ring-2 focus:ring-blue-500 dark:text-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2 ml-1">Nilai Total</label>
                        <input type="number" name="nilai_total" step="0.01" min="0" max="100" required placeholder="0-100" class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm outline-none transition-all focus:ring-2 focus:ring-blue-500 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2 ml-1">Label (Status Kerja)</label>
                        <select name="label" required class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm outline-none transition-all focus:ring-2 focus:ring-blue-500 dark:text-white">
                            <option value="Siap">SIAP KERJA</option>
                            <option value="Tidak Siap">TIDAK SIAP</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-3 bg-primary-n5 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transition-all mt-4 flex justify-center items-center group">
                        Simpan Data
                        <svg class="w-4 h-4 ml-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </button>
                </form>
            </div>
        </div>

        {{-- Tabel Dataset (KONTEN TETAP SAMA SEPERTI MILIK USER) --}}
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
                                <th class="px-2 py-3 text-center font-semibold">Sidang</th>
                                <th class="px-2 py-3 text-center font-semibold">Instansi</th>
                                <th class="px-2 py-3 text-center font-semibold">Total</th>
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
                                <td class="px-2 py-4 text-center font-mono text-xs">{{ $data->nilai_pkl }}</td>
                                <td class="px-2 py-4 text-center font-mono text-xs">{{ $data->nilai_sidang }}</td>
                                <td class="px-2 py-4 text-center font-mono text-xs">{{ $data->nilai_total }}</td>
                                <td class="px-4 py-4 text-center">
                                    @if($data->label == 'Siap')
                                        <span class="px-3 py-1 bg-green-500/10 text-green-500 rounded-full text-[9px] font-black uppercase tracking-tighter border border-green-500/20">SIAP</span>
                                    @else
                                        <span class="px-3 py-1 bg-red-500/10 text-red-500 rounded-full text-[9px] font-black uppercase tracking-tighter border border-red-500/20">TIDAK</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-right">
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
                            <tr><td colspan="6" class="text-center py-12 text-gray-500">Dataset Kosong</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>