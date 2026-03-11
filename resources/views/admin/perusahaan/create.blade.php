<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        {{-- 1. NOTIFIKASI ERROR (WAJIB ADA BIAR GAK BINGUNG) --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Ada kesalahan input:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-2xl shadow-none dark:shadow-2xl overflow-hidden">
            {{-- Form Header --}}
            <div class="bg-gradient-to-r from-blue-100 to-blue-50 dark:from-white/5 dark:to-white/10 border-b border-gray-200 dark:border-white/10 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Form Tambah Perusahaan</h3>
                        <p class="text-gray-500 dark:text-slate-400 text-sm mt-1">Lengkapi data untuk menambahkan mitra PKL baru</p>
                    </div>
                </div>
            </div>

            {{-- Form Body --}}
            <div class="p-8">
                <form method="POST" action="{{ route('admin.perusahaan.store') }}" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nama Perusahaan --}}
                        <div class="col-span-2 space-y-2">
                            <x-input-label for="nama" :value="'Nama Perusahaan *'" />
                            <x-text-input name="nama" id="nama" type="text" class="w-full" :value="old('nama')" required autofocus />
                        </div>

                        {{-- Bidang Usaha (INI YANG TADI KURANG) --}}
                        <div class="space-y-2">
                            <x-input-label for="bidang_usaha" :value="'Bidang Usaha *'" />
                            <x-text-input name="bidang_usaha" id="bidang_usaha" type="text" class="w-full" :value="old('bidang_usaha')" placeholder="Contoh: Teknologi Informasi" required />
                        </div>

                        {{-- Kuota (INI JUGA TADI KURANG) --}}
                        <div class="space-y-2">
                            <x-input-label for="kuota" :value="'Kuota Siswa *'" />
                            <x-text-input name="kuota" id="kuota" type="number" class="w-full" :value="old('kuota', 1)" min="1" required />
                        </div>

                        {{-- No Telepon --}}
                        <div class="col-span-2 md:col-span-1 space-y-2">
                            <x-input-label for="no_hp" :value="'No. Telepon / WhatsApp *'" />
                            <x-text-input name="no_hp" id="no_hp" type="text" class="w-full" :value="old('no_hp')" required />
                        </div>

                        {{-- Alamat --}}
                        <div class="col-span-2 space-y-2">
                            <x-input-label for="alamat" :value="'Alamat Lengkap *'" />
                            <textarea name="alamat" id="alamat" rows="3" class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/20 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-blue-500" required>{{ old('alamat') }}</textarea>
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-white/10">
                        <a href="{{ route('admin.perusahaan.index') }}" class="px-6 py-3 text-gray-700 dark:text-slate-300 font-medium">Batal</a>
                        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-emerald-500 to-green-600 rounded-xl text-white font-semibold shadow-lg hover:shadow-xl transition-all flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Simpan Perusahaan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>