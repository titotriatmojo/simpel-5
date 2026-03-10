<x-app-layout>
    {{-- Header Section --}}
    <div class="mb-8 bg-white dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-2xl p-6 dark:shadow-lg">
        <div class="flex items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-white mb-2">Manajemen Nilai PKL</h1>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Input, edit, atau perbarui penilaian Praktik Kerja Lapangan siswa bimbingan Anda.</p>
            </div>
        </div>
        <div class="mt-4">
            <div class="w-32 h-1 bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full"></div>
        </div>
    </div>

    {{-- Pesan sukses --}}
    @if (session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
        class="mb-6 bg-emerald-100/80 dark:bg-emerald-500/10 backdrop-blur-sm text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-500/30 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-3 shadow-sm">
        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Main Content --}}
    <div class="space-y-4">
        @forelse ($siswa as $mhs)
        <div x-data="{ isEditing: false }" class="group relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-white/10 shadow-sm transition-all hover:shadow-md">
            
            {{-- Student Info Header --}}
            <div class="p-6 pb-4">
                <div class="flex items-start justify-between">
                    <div class="space-y-1">
                        <h3 class="text-xl font-semibold text-slate-800 dark:text-white uppercase tracking-tight">
                            {{ $mhs->nama }}
                        </h3>
                        <div class="flex items-center space-x-4 text-sm">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-400/30">
                                NISN: {{ $mhs->nim }}
                            </span>
                        </div>
                    </div>

                    {{-- Status Indicator --}}
                    <div>
                        @if ($mhs->nilaiPkl)
                        <div class="flex items-center space-x-2 bg-emerald-50 dark:bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-200 dark:border-emerald-500/30 shadow-sm">
                            <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                            <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase">Sudah Dinilai</span>
                        </div>
                        @else
                        <div class="flex items-center space-x-2 bg-amber-50 dark:bg-amber-500/10 px-3 py-1 rounded-full border border-amber-200 dark:border-amber-500/30 shadow-sm">
                            <div class="w-2 h-2 bg-amber-400 rounded-full animate-pulse"></div>
                            <span class="text-xs font-bold text-amber-700 dark:text-amber-400 uppercase">Belum Dinilai</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Content Section --}}
            <div class="px-6 pb-6">
                @if ($mhs->nilaiPkl)
                    {{-- Tampilan Nilai (View Mode) --}}
                    <div x-show="!isEditing" class="flex items-center justify-between bg-slate-50 dark:bg-white/5 rounded-xl p-5 border border-slate-100 dark:border-white/5 shadow-inner">
                        <div class="flex items-center gap-4">
                            <div class="text-4xl font-black text-slate-800 dark:text-emerald-400">
                                {{ number_format($mhs->nilaiPkl->nilai, 2) }}
                            </div>
                            <div class="h-10 w-[2px] bg-slate-200 dark:bg-white/10"></div>
                            <div>
                                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Nilai Akhir</p>
                                <p class="text-[10px] text-slate-400 italic">Terakhir diupdate: {{ $mhs->nilaiPkl->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        
                        {{-- Button Actions --}}
                        <div class="flex gap-2">
                            {{-- Edit Button --}}
                            <button @click="isEditing = true" class="p-2.5 text-blue-600 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-500/20 dark:text-blue-400 rounded-xl transition-all shadow-sm border border-blue-200 dark:border-blue-500/30" title="Edit Nilai">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>

                            {{-- Delete Button (New) --}}
                            <form action="{{ route('guru.nilai.destroy', $mhs->nilaiPkl->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus nilai ini? Data yang dihapus tidak dapat dikembalikan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 text-rose-600 hover:bg-rose-600 hover:text-white dark:hover:bg-rose-500/20 dark:text-rose-400 rounded-xl transition-all shadow-sm border border-rose-200 dark:border-rose-500/30" title="Hapus Nilai">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Form Edit (Edit Mode) --}}
                    <div x-show="isEditing" x-cloak x-transition>
                        <form method="POST" action="{{ route('guru.nilai.update', $mhs->nilaiPkl->id) }}" class="flex flex-col md:flex-row gap-3 p-2 bg-blue-50/50 dark:bg-blue-500/5 rounded-2xl border border-blue-100 dark:border-blue-500/20">
                            @csrf
                            @method('PUT')
                            <div class="flex-1">
                                <input type="number" name="nilai" step="0.01" min="0" max="100" value="{{ $mhs->nilaiPkl->nilai }}"
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-900 border-2 border-blue-400 dark:border-blue-500 rounded-xl text-slate-800 dark:text-white focus:ring-4 focus:ring-blue-500/20 outline-none transition-all font-bold text-lg" required>
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-lg shadow-blue-500/30 flex-1 md:flex-none">
                                    Simpan Perubahan
                                </button>
                                <button type="button" @click="isEditing = false" class="bg-slate-200 dark:bg-white/10 text-slate-600 dark:text-slate-300 font-bold py-3 px-6 rounded-xl hover:bg-slate-300 transition-all flex-1 md:flex-none">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    {{-- Form Input Baru --}}
                    <form method="POST" action="{{ route('guru.nilai.store') }}" class="flex flex-col md:flex-row gap-3">
                        @csrf
                        <input type="hidden" name="siswa_id" value="{{ $mhs->id }}">
                        <div class="flex-1">
                            <input type="number" name="nilai" step="0.01" min="0" max="100"
                                class="w-full px-4 py-3 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl text-slate-800 dark:text-white focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all"
                                placeholder="Masukkan nilai (0-100)..." required>
                        </div>
                        <button type="submit" class="bg-slate-800 dark:bg-emerald-600 hover:bg-slate-900 dark:hover:bg-emerald-700 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-emerald-500/20 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Kirim Nilai
                        </button>
                    </form>
                @endif
            </div>
        </div>
        @empty
        {{-- Empty State tetap sama --}}
        <div class="text-center py-20 bg-white dark:bg-white/[0.03] border-2 border-dashed border-gray-200 dark:border-white/10 rounded-3xl">
            <div class="max-w-md mx-auto">
                <div class="w-20 h-20 bg-slate-100 dark:bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white">Data Siswa Kosong</h3>
                <p class="text-slate-500 dark:text-slate-400 mt-2">Belum ada siswa yang terdaftar di bawah bimbingan Anda atau status pendaftaran mereka belum disetujui.</p>
            </div>
        </div>
        @endforelse
    </div>
</x-app-layout>