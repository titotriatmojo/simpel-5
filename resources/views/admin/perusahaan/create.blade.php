<x-app-layout>
    <div class="max-w-5xl mx-auto py-6">
        <div class="bg-white dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-2xl shadow-none dark:shadow-2xl overflow-hidden">
            
            {{-- Header Form --}}
            <div class="bg-gradient-to-r from-emerald-100 to-teal-50 dark:from-white/5 dark:to-white/10 border-b border-gray-200 dark:border-white/10 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Form Tambah Mitra PKL</h3>
                        <p class="text-gray-500 dark:text-slate-400 text-sm mt-1">Input lokasi PKL baru yang akan langsung aktif di sistem</p>
                    </div>
                    <div class="hidden md:block">
                        <span class="px-3 py-1 bg-emerald-500 text-white text-xs font-bold rounded-full border border-emerald-600 shadow-sm">
                            AUTO APPROVED
                        </span>
                    </div>
                </div>
            </div>

            {{-- Body Form --}}
            <div class="p-8">
                <form method="POST" action="{{ route('admin.perusahaan.store') }}" class="space-y-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        {{-- Kolom Kiri: Detail Instansi --}}
                        <div class="space-y-6">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="p-2 bg-blue-500/10 rounded-lg text-blue-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <h4 class="font-bold text-gray-800 dark:text-white">Detail Perusahaan</h4>
                            </div>

                            <div class="space-y-2">
                                <x-input-label for="nama" :value="'Nama Perusahaan *'" />
                                <x-text-input name="nama" id="nama" type="text" class="w-full" :value="old('nama')" placeholder="PT Maju Jaya" required autofocus />
                            </div>

                            <div class="space-y-2">
                                <x-input-label for="bidang_usaha" :value="'Bidang Usaha *'" />
                                <x-text-input name="bidang_usaha" id="bidang_usaha" type="text" class="w-full" :value="old('bidang_usaha')" placeholder="Contoh: Transportasi / Jaringan" required />
                            </div>

                            <div class="space-y-2">
                                <x-input-label for="alamat" :value="'Alamat Lengkap *'" />
                                <textarea name="alamat" id="alamat" rows="3" class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-emerald-500" placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
                            </div>

                            <div class="space-y-2">
                                <x-input-label for="koordinat_lokasi" :value="'Link Google Maps (Koordinat)'" />
                                <x-text-input name="koordinat_lokasi" id="koordinat_lokasi" type="text" class="w-full" :value="old('koordinat_lokasi')" placeholder="https://maps.google.com/..." />
                            </div>
                        </div>

                        {{-- Kolom Kanan: Kontak & Kapasitas --}}
                        <div class="space-y-6">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="p-2 bg-emerald-500/10 rounded-lg text-emerald-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <h4 class="font-bold text-gray-800 dark:text-white">Kontak Person</h4>
                            </div>

                            <div class="space-y-2">
                                <x-input-label for="pembimbing_lapangan" :value="'Nama Supervisor/HRD *'" />
                                <x-text-input name="pembimbing_lapangan" id="pembimbing_lapangan" type="text" class="w-full" :value="old('pembimbing_lapangan')" placeholder="Nama orang yang bisa dihubungi" required />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <x-input-label for="no_hp" :value="'No. Telepon/WhatsApp *'" />
                                    <x-text-input name="no_hp" id="no_hp" type="text" class="w-full" :value="old('no_hp')" placeholder="08..." required />
                                </div>
                                <div class="space-y-2">
                                    <x-input-label for="email" :value="'Email (Opsional)'" />
                                    <x-text-input name="email" id="email" type="email" class="w-full" :value="old('email')" placeholder="hrd@perusahaan.com" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <x-input-label for="kuota" :value="'Kuota Siswa *'" />
                                    <x-text-input name="kuota" id="kuota" type="number" min="1" class="w-full" :value="old('kuota', 1)" required />
                                </div>
                                <div class="space-y-2">
                                    <x-input-label :value="'Status Usulan'" />
                                    <div class="px-4 py-2.5 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 rounded-xl text-emerald-600 dark:text-emerald-400 text-sm font-bold flex items-center gap-2 uppercase tracking-tight">
                                        <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                                        Approved (Admin)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-white/10">
                        <p class="text-xs text-gray-400 italic">Pastikan data valid untuk memudahkan monitoring siswa.</p>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('admin.perusahaan.index') }}" class="px-6 py-3 text-sm font-medium text-gray-600 dark:text-slate-400">Batal</a>
                            <button type="submit" class="px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold shadow-lg shadow-emerald-500/20 transition-all flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Simpan Perusahaan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>