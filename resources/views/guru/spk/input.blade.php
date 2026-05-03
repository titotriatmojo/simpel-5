<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <nav class="flex mb-5 text-gray-500 text-sm" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1">
                    <li class="inline-flex items-center">
                        <a href="{{ route('guru.spk.index') }}" class="text-gray-700 hover:text-primary-n5 dark:text-gray-400">
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
                            Input Nilai Instasi PKL
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Siswa: <span class="font-bold text-primary-n5 dark:text-white">{{ $siswa->siswa->nama ?? $siswa->name }}</span> 
                            <span class="mx-1">|</span> 
                            NISN: <span class="font-mono">{{ $siswa->siswa->nim ?? '-' }}</span>
                        </p>
                    </div>

                <form action="{{ route('guru.spk.store', $siswa->id) }}" method="POST" class="space-y-6">
                    @csrf
                    
                    {{-- Input Nilai PKL --}}
                    <div>
                        <label for="nilai_pkl" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            Nilai PKL dari Instansi
                        </label>
                        <input type="number" step="0.01" name="nilai_pkl" id="nilai_pkl"
                            value="{{ old('nilai_pkl', $siswa->nilai_pkl) }}" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-n5 focus:border-primary-n5 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                            placeholder="0.00 - 100.00" required>
                        @error('nilai_pkl')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nilai Guru (AUTO / READ ONLY) --}}
                    <div class="bg-primary-n5/20 p-4 rounded-lg flex justify-between items-center">
                        <span class="text-sm font-medium text-primary-n5 dark:text-white">
                            Nilai Sidang (Guru)
                        </span>
                        <span class="text-lg font-bold text-primary-n5 dark:text-white">
                            {{ number_format(optional($siswa->nilaiPkl)->nilai ?? 0, 2) }}
                        </span>
                    </div>

                    <div class="flex items-center justify-end gap-3 mt-8">
                        <a href="{{ route('guru.spk.index') }}" class="text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 font-medium rounded-lg text-sm px-5 py-2.5">
                            Batal
                        </a>
                        <button type="submit" class="text-white bg-primary-n5 hover:bg-primary-n5/90 rounded-lg text-sm px-5 py-2.5">
                            Simpan
                        </button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>