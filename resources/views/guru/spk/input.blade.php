<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <nav class="flex mb-5 text-gray-500 text-sm" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1">
                    <li class="inline-flex items-center">
                        <a href="{{ route('guru.spk.index') }}" class="text-gray-700 hover:text-blue-600 dark:text-gray-400">
                            Analisis KNN
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 11H3a1 1 0 110-2h7.586l-3.293-3.293a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 font-medium text-gray-500">Input Nilai</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-8">
                    <div class="mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                            Input Parameter KNN
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Siswa: <span class="font-bold text-blue-600">{{ $siswa->siswa->nama ?? $siswa->name }}</span> 
                            <span class="mx-1">|</span> 
                            NIM: <span class="font-mono">{{ $siswa->siswa->nim ?? '-' }}</span>
                        </p>
                    </div>

                    <form action="{{ route('guru.spk.store', $siswa->id) }}" method="POST" class="space-y-6">
                        @csrf
                        
                        {{-- Input Nilai Akademik --}}
                        <div>
                            <label for="nilai_akademik" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                Rata-rata Nilai Akademik (Rapor)
                            </label>
                            <input type="number" step="0.01" name="nilai_akademik" id="nilai_akademik"
                                value="{{ old('nilai_akademik', $siswa->nilai_akademik) }}" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                                placeholder="0.00 - 100.00" required>
                            @error('nilai_akademik')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Input Nilai Instansi --}}
                        <div>
                            <label for="nilai_instansi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                Nilai dari Instansi (DUDI)
                            </label>
                            <input type="number" step="0.01" name="nilai_instansi" id="nilai_instansi"
                                value="{{ old('nilai_instansi', $siswa->nilai_instansi) }}" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                                placeholder="0.00 - 100.00" required>
                            @error('nilai_instansi')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Info Nilai Pembimbing (Read Only) --}}
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg flex justify-between items-center">
                            <span class="text-sm text-blue-800 dark:text-blue-300 font-medium">Nilai Pembimbing (PKL):</span>
                            <span class="text-lg font-bold text-blue-900 dark:text-blue-100">
                                {{ $siswa->nilaiPkl->nilai ?? '0.00' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-end gap-3 mt-8">
                            <a href="{{ route('guru.spk.index') }}" class="text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                                Batal
                            </a>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>