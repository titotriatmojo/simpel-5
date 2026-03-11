<x-app-layout>
    {{-- Header Section --}}
    <div class="mb-8 bg-white dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-2xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Data Perusahaan Mitra</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Kelola daftar instansi dan validasi usulan tempat PKL dari siswa.</p>
            </div>
            <a href="{{ route('admin.perusahaan.create') }}"
                class="inline-flex items-center justify-center px-5 py-3 bg-primary-n5 hover:bg-secondary-n5 text-white font-bold rounded-xl transition-all duration-200 shadow-lg shadow-primary-n5/25 group">
                <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Instansi
            </a>
        </div>
        <div class="mt-4">
            <div class="w-32 h-1.5 bg-gradient-to-r from-primary-n5 to-secondary-n5 rounded-full"></div>
        </div>
    </div>

    {{-- Pencarian & Filter --}}
    <div class="mb-6 bg-white dark:bg-gray-800/50 p-4 rounded-2xl border border-gray-200 dark:border-white/10 shadow-sm">
        <form method="GET" action="{{ route('admin.perusahaan.index') }}" class="flex flex-col md:flex-row gap-3">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8" /><path d="M21 21l-4.35-4.35" stroke-linecap="round" stroke-width="2"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama perusahaan, alamat, atau pengusul..."
                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
            </div>
            <button type="submit" class="px-6 py-3 bg-slate-800 dark:bg-slate-700 text-white font-semibold rounded-xl hover:bg-slate-900 transition-colors">
                Filter Data
            </button>
            @if(request('search'))
                <a href="{{ route('admin.perusahaan.index') }}" class="px-6 py-3 bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-300 rounded-xl flex items-center justify-center hover:bg-gray-200 transition-all">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
        class="mb-6 bg-emerald-100/80 dark:bg-emerald-500/10 backdrop-blur-sm text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-500/30 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-3">
        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Table Section --}}
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-white/10 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 dark:bg-white/5 border-b border-gray-200 dark:border-white/10">
                    <tr>
                        <th class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider w-16">No</th>
                        <th class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Informasi Perusahaan</th>
                        <th class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider text-center">Pengusul</th>
                        <th class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider text-center">Status</th>
                        <th class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                    @forelse($perusahaan as $index => $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-4 text-gray-500 dark:text-gray-400 font-medium">
                            {{ $perusahaan->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-900 dark:text-white text-base">{{ $item->nama }}</span>
                                <span class="text-gray-500 dark:text-gray-400 flex items-center mt-1">
                                    <svg class="w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ Str::limit($item->alamat, 50) }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($item->pengusul)
                                <div class="inline-flex flex-col items-center">
                                    <span class="font-semibold text-primary-n5 dark:text-white">{{ $item->pengusul->nama }}</span>
                                    <span class="text-[10px] font-bold px-2 py-0.5 bg-blue-100 dark:bg-blue-500/20 text-blue-600 rounded-full mt-1 uppercase tracking-tight">Siswa</span>
                                </div>
                            @else
                                <span class="text-xs font-semibold text-gray-400 dark:text-white uppercase tracking-widest">Internal / Admin</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400 border-amber-200 dark:border-amber-500/30',
                                    'approved' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/30',
                                    'rejected' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-400 border-rose-200 dark:border-rose-500/30',
                                ];
                                $statusLabels = ['pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'];
                            @endphp
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold border {{ $statusClasses[$item->status] ?? $statusClasses['pending'] }}">
                                {{ $statusLabels[$item->status] ?? 'Unknown' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-end gap-2">
                                @if($item->status == 'pending')
                                    <form action="{{ route('admin.perusahaan.approve', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="p-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg shadow-sm transition-all" title="Setujui">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.perusahaan.reject', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="p-2 bg-rose-500 hover:bg-rose-600 text-white rounded-lg shadow-sm transition-all" title="Tolak">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('admin.perusahaan.edit', $item) }}" class="p-2 text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-500/10 rounded-lg transition-all" title="Edit Data">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>

                                <form method="POST" action="{{ route('admin.perusahaan.destroy', $item) }}" onsubmit="return confirm('Hapus data perusahaan? Pastikan tidak ada siswa yang terdaftar di sini.')">
                                    @csrf @method('DELETE')
                                    <button class="p-2 text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-lg transition-all" title="Hapus Permanen">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-24 text-center">
                            <div class="flex flex-col items-center">
                                <div class="p-4 bg-gray-100 dark:bg-white/5 rounded-full mb-4">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">Belum ada data perusahaan</p>
                                <p class="text-gray-400 text-sm">Data perusahaan yang diusulkan siswa akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination Section --}}
    <div class="mt-8 px-2">
        {{ $perusahaan->links() }}
    </div>
</x-app-layout>