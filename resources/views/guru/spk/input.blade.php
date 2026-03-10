<x-app-layout>
    <div class="max-w-2xl mx-auto">
        {{-- Breadcrumb --}}
        <nav class="flex mb-5 text-gray-500 text-sm" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('guru.spk.index') }}" class="hover:text-blue-600">Analisis</a>
                </li>
                <li><div class="flex items-center"><svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 11H3a1 1 0 110-2h7.586l-3.293-3.293a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                <span class="ml-1 font-medium text-gray-900 dark:text-white">Input Nilai</span></div></li>
            </ol>
        </nav>

        <div class="bg-white dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-3xl p-8 shadow-xl">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Input Parameter KNN</h2>
                <p class="text-gray-500 dark:text-gray-400">Masukkan nilai untuk <strong>{{ $siswa->nama }}</strong> (NIM: {{ $siswa->nim }})</p>
            </div>

            <form action="{{ route('guru.spk.store', $siswa->id) }}" method="POST" class="space-y-6">
                @csrf
                {{-- Input Nilai Akademik --}}
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700 dark:text-gray-300">Rata-rata Nilai Akademik (Rapor)</label>
                    <input type="number" step="0.01" name="nilai_akademik" value="{{ $siswa->nilai_akademik }}" 
                        class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-white/5 border-gray-200 dark:border-white/10 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 transition-all" 
                        placeholder="Contoh: 85.50" required>
                </div>

                {{-- Input Nilai Instansi --}}
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700 dark:text-gray-300">Nilai dari Instansi (DUDI)</label>
                    <input type="number" step="0.01" name="nilai_instansi" value="{{ $siswa->nilai_instansi }}" 
                        class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-white/5 border-gray-200 dark:border-white/10 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 transition-all" 
                        placeholder="Contoh: 90.00" required>
                </div>

                <div class="pt-4 flex items-center gap-3">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-blue-500/30 transition-all active:scale-[0.98]">
                        Simpan Data
                    </button>
                    <a href="{{ route('guru.spk.index') }}" class="px-6 py-3 bg-gray-100 dark:bg-white/10 text-gray-600 dark:text-gray-300 font-bold rounded-xl hover:bg-gray-200 dark:hover:bg-white/20 transition-all text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>