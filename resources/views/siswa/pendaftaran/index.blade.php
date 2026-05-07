<x-app-layout>
    {{-- Header Section --}}
    <div class="mb-8 bg-white dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-2xl p-6 dark:shadow-lg">
        <div class="flex items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Pendaftaran PKL</h1>
                <p class="text-gray-900 dark:text-blue-100 text-sm">
                    @if(!$pendaftaran)
                        Silahkan lengkapi form untuk mendaftar PKL.
                    @elseif($pendaftaran->status === 'menunggu')
                        Anda dapat mengubah data pendaftaran selama status masih menunggu.
                    @else
                        Pantau status PKL Anda secara berkala.
                    @endif
                </p>
            </div>
        </div>
        <div class="mt-4">
            <div class="w-32 h-1 bg-gradient-to-r from-primary-n5 to-secondary-n5 rounded-full"></div>
        </div>
    </div>

    {{-- Form Section (Hanya muncul jika BELUM daftar atau status MENUNGGU) --}}
    @if(!$pendaftaran || $pendaftaran->status === 'menunggu')
    <div class="mb-8 backdrop-blur-sm bg-white dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-2xl dark:shadow-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-cyan-400 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ $pendaftaran ? 'Edit Pendaftaran PKL' : 'Form Pendaftaran PKL' }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-slate-400">Pastikan data yang Anda masukkan sudah benar.</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ $pendaftaran ? route('siswa.pendaftaran.update', $pendaftaran->id) : route('siswa.pendaftaran.store') }}" method="POST" class="space-y-6">
                @csrf
                @if($pendaftaran) @method('PUT') @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Perusahaan --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white/90">Pilih Perusahaan <span class="text-red-600">*</span></label>
                        <div class="relative group">
                            <select name="perusahaan_id" required class="w-full px-4 py-3 bg-white dark:bg-white/[0.05] text-gray-900 dark:text-white rounded-lg border border-gray-200 dark:border-white/20 focus:ring-2 focus:ring-blue-500/50 appearance-none transition-all">
                                <option value="">Pilih Perusahaan</option>
                                @foreach($perusahaan as $item)
                                    <option value="{{ $item->id }}" @selected($pendaftaran?->perusahaan_id == $item->id)>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Guru Pembimbing --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white/90">Pilih Guru Pembimbing <span class="text-red-600">*</span></label>
                        <div class="relative group">
                            <select name="guru_id" required class="w-full px-4 py-3 bg-white dark:bg-white/[0.05] text-gray-900 dark:text-white rounded-lg border border-gray-200 dark:border-white/20 focus:ring-2 focus:ring-blue-500/50 appearance-none">
                                <option value="">Pilih Guru Pembimbing</option>
                                @foreach($guru as $g)
                                    <option value="{{ $g->id }}" @selected($pendaftaran?->guru_id == $g->id)>
                                        {{ $g->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Bidang PKL --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white/90">Posisi <span class="text-red-600">*</span></label>
                        <input type="text" name="bidang_pkl" value="{{ $pendaftaran?->bidang_pkl }}" required placeholder="Contoh: Programmer" class="w-full px-4 py-3 bg-white dark:bg-white/[0.05] text-gray-900 dark:text-white rounded-lg border border-gray-200 dark:border-white/20 focus:ring-2 focus:ring-blue-500/50" />
                    </div>

                    {{-- Periode --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white/90">Periode <span class="text-red-600">*</span></label>
                        <input type="text" name="periode" value="{{ $pendaftaran?->periode }}" required placeholder="Contoh: Januari - Juni 2026" class="w-full px-4 py-3 bg-white dark:bg-white/[0.05] text-gray-900 dark:text-white rounded-lg border border-gray-200 dark:border-white/20 focus:ring-2 focus:ring-blue-500/50" />
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200 dark:border-white/10 flex justify-between items-center">
                    @if($pendaftaran)
                        <p class="text-xs text-yellow-600 dark:text-yellow-400 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"/></svg>
                            Data dapat diubah selama status belum disetujui.
                        </p>
                    @else
                        <span></span>
                    @endif
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white text-sm font-medium rounded-lg transition-all shadow-lg shadow-blue-500/25">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        {{ $pendaftaran ? 'Perbarui Pendaftaran' : 'Daftar PKL Sekarang' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Info Card Section (Muncul jika SUDAH daftar) --}}
    @if($pendaftaran)
    <div class="bg-white dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-2xl p-8 dark:shadow-2xl">
        <div class="text-center mb-8">
            {{-- Dynamic Icons based on Status --}}
            @if($pendaftaran->status === 'diterima')
                <div class="w-16 h-16 bg-green-100 dark:bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-4 border border-green-200 dark:border-green-500/30 shadow-lg shadow-green-500/20">
                    <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Pendaftaran Diterima!</h3>
            @elseif($pendaftaran->status === 'ditolak')
                <div class="w-16 h-16 bg-red-100 dark:bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-200 dark:border-red-500/30">
                    <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Pendaftaran Ditolak</h3>
            @else
                <div class="w-16 h-16 bg-yellow-100 dark:bg-yellow-500/20 rounded-full flex items-center justify-center mx-auto mb-4 border border-yellow-200 dark:border-yellow-500/30">
                    <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" /></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Pendaftaran Sedang Ditinjau</h3>
            @endif
            <p class="text-gray-500 text-sm mt-2">Detail data pendaftaran aktif Anda saat ini.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Info Cards dengan Icon --}}
            <div class="bg-gray-50 dark:bg-white/5 p-4 rounded-xl border border-gray-200 dark:border-white/10 flex items-center gap-3">
                <div class="text-blue-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1" /></svg></div>
                <div>
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider">Perusahaan</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $pendaftaran->perusahaan->nama }}</p>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-white/5 p-4 rounded-xl border border-gray-200 dark:border-white/10 flex items-center gap-3">
                <div class="text-indigo-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg></div>
                <div>
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider">Pembimbing</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $pendaftaran->guru?->nama ?? 'Menunggu Admin' }}</p>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-white/5 p-4 rounded-xl border border-gray-200 dark:border-white/10 flex items-center gap-3">
                <div class="text-orange-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg></div>
                <div>
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider">Bidang</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $pendaftaran->bidang_pkl }}</p>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-white/5 p-4 rounded-xl border border-gray-200 dark:border-white/10 flex items-center gap-3">
                <div class="text-emerald-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                <div>
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider">Status</p>
                    <span class="text-sm font-bold capitalize {{ $pendaftaran->status === 'diterima' ? 'text-green-500' : ($pendaftaran->status === 'ditolak' ? 'text-red-500' : 'text-yellow-500') }}">
                        {{ $pendaftaran->status }}
                    </span>
                </div>
            </div>
        </div>

        @if($pendaftaran->status === 'ditolak')
            <div class="mt-8 flex justify-center">
                <form action="{{ route('siswa.pendaftaran.destroy', $pendaftaran->id) }}" method="POST" onsubmit="return confirm('Data lama akan dihapus. Lanjutkan?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="group relative px-8 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold shadow-lg shadow-red-500/30 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        Hapus & Daftar Ulang
                    </button>
                </form>
            </div>
        @endif
    </div>
    @endif
</x-app-layout>