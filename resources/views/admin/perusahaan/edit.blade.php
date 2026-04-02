<x-app-layout>
    <div class="bg-white dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-2xl shadow-none dark:shadow-2xl overflow-hidden">
        
        {{-- Form Header --}}
        <div class="bg-gradient-to-r from-blue-100 to-blue-50 dark:from-white/5 dark:to-white/10 border-b border-gray-200 dark:border-white/10 px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Form Edit Perusahaan</h3>
                    <p class="text-gray-500 dark:text-slate-400 text-sm mt-1">Perbarui detail instansi dan status verifikasi</p>
                </div>
                <div class="flex items-center space-x-2 text-gray-500 dark:text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-xs">* Field wajib diisi</span>
                </div>
            </div>
        </div>

        {{-- Form Body --}}
        <div class="p-8">
            <form method="POST" action="{{ route('admin.perusahaan.update', $perusahaan) }}" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    {{-- Kolom Kiri: Detail Instansi --}}
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-blue-500/10 rounded-lg text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <h4 class="font-bold text-gray-800 dark:text-white">Data Instansi</h4>
                        </div>

                        <div class="space-y-2">
                            <x-input-label for="nama" :value="'Nama Perusahaan *'" />
                            <x-text-input name="nama" id="nama" type="text" class="w-full" :value="old('nama', $perusahaan->nama)" required />
                            <x-input-error :messages="$errors->get('nama')" />
                        </div>

                        <div class="space-y-2">
                            <x-input-label for="bidang_usaha" :value="'Bidang Usaha *'" />
                            <x-text-input name="bidang_usaha" id="bidang_usaha" type="text" class="w-full" :value="old('bidang_usaha', $perusahaan->bidang_usaha)" required />
                            <x-input-error :messages="$errors->get('bidang_usaha')" />
                        </div>

                        <div class="space-y-2">
                            <x-input-label for="alamat" :value="'Alamat Lengkap *'" />
                            <textarea name="alamat" id="alamat" rows="3" class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500" required>{{ old('alamat', $perusahaan->alamat) }}</textarea>
                            <x-input-error :messages="$errors->get('alamat')" />
                        </div>

                        <div class="space-y-2">
                            <x-input-label for="koordinat_lokasi" :value="'Link Google Maps'" />
                            <x-text-input name="koordinat_lokasi" id="koordinat_lokasi" type="text" class="w-full" :value="old('koordinat_lokasi', $perusahaan->koordinat_lokasi)" />
                        </div>
                    </div>

                    {{-- Kolom Kanan: Kontak & Status --}}
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-emerald-500/10 rounded-lg text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <h4 class="font-bold text-gray-800 dark:text-white">Kontak & Kapasitas</h4>
                        </div>

                        <div class="space-y-2">
                            <x-input-label for="pembimbing_lapangan" :value="'Nama Supervisor/HRD *'" />
                            <x-text-input name="pembimbing_lapangan" id="pembimbing_lapangan" type="text" class="w-full" :value="old('pembimbing_lapangan', $perusahaan->pembimbing_lapangan)" required />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <x-input-label for="no_hp" :value="'No. Telepon *'" />
                                <x-text-input name="no_hp" id="no_hp" type="text" class="w-full" :value="old('no_hp', $perusahaan->no_hp)" required />
                            </div>
                            <div class="space-y-2">
                                <x-input-label for="email" :value="'Email'" />
                                <x-text-input name="email" id="email" type="email" class="w-full" :value="old('email', $perusahaan->email)" />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <x-input-label for="kuota" :value="'Kuota Siswa *'" />
                                    <x-text-input name="kuota" id="kuota" type="number" class="w-full" :value="old('kuota', $perusahaan->kuota)" required />
                                </div>
                                
                                {{-- Status Verifikasi: Ganti Select dengan Informasi Otomatis --}}
                                <div class="space-y-2">
                                    <x-input-label :value="'Status Verifikasi'" />
                                    <div class="px-4 py-2.5 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 rounded-xl flex items-center space-x-2 text-emerald-600 dark:text-emerald-400">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="font-bold text-xs uppercase tracking-wider">Auto Approved</span>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-white/10">
                    <div class="flex items-center space-x-2 text-gray-500 dark:text-slate-400 text-sm italic">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Perubahan status ke "Disetujui" akan membuat perusahaan ini muncul di daftar siswa.</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.perusahaan.index') }}" class="px-6 py-3 bg-gray-100 dark:bg-white/10 hover:bg-gray-200 dark:hover:bg-white/20 border border-gray-200 dark:border-white/20 rounded-xl text-gray-700 dark:text-slate-300 transition-all duration-200 font-medium">
                            Batal
                        </a>
                        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-emerald-400 to-green-500 text-white rounded-xl font-bold shadow-lg shadow-emerald-500/20 hover:scale-[1.02] active:scale-95 transition-all flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>