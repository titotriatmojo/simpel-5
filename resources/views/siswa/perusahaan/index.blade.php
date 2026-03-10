<x-app-layout>
    {{-- Header Section --}}
    <div class="mb-8 bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700 pb-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Direktori Perusahaan Mitra PKL</h1>
                <p class="text-gray-500 dark:text-slate-400 text-sm">
                    Informasi resmi data mitra industri untuk pelaksanaan Praktik Kerja Lapangan.
                </p>
            </div>
            <div class="text-right">
                <span class="text-xs font-medium text-gray-400 dark:text-slate-500 uppercase tracking-widest">Total Data</span>
                <p class="text-2xl font-black text-blue-600 dark:text-blue-400">{{ $perusahaan->total() }}</p>
            </div>
        </div>
    </div>

    {{-- Pencarian & Aksi --}}
    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
        <form method="GET" action="{{ route('siswa.perusahaan') }}" class="flex items-center gap-2 w-full md:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" 
                placeholder="Cari perusahaan atau alamat..."
                class="h-11 px-4 rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm w-full md:w-72 focus:border-blue-500 focus:ring-blue-500">
            
            <button type="submit" class="h-11 px-5 bg-slate-800 dark:bg-blue-600 hover:bg-slate-900 dark:hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-all">
                Cari
            </button>
        </form>

        <a href="{{ route('siswa.perusahaan.create') }}"
            class="inline-flex items-center px-5 py-2.5 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-200 font-semibold rounded-lg text-sm hover:bg-gray-50 dark:hover:bg-slate-700 transition-all gap-2 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Saran Mitra Baru
        </a>
    </div>

    {{-- Daftar Perusahaan --}}
    <div class="grid grid-cols-1 gap-4">
        @forelse($perusahaan as $item)
        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white capitalize">
                            {{ $item->nama }}
                        </h2>
                        <span class="px-2 py-0.5 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-[10px] font-bold rounded uppercase tracking-tighter">
                            Aktif
                        </span>
                    </div>

                    {{-- Info Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-3 gap-x-6">
                        <div class="flex items-start gap-2 text-sm text-gray-600 dark:text-slate-400">
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="line-clamp-1">{{ $item->alamat }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                            <svg class="w-4 h-4 shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>{{ $item->no_hp }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                            <svg class="w-4 h-4 shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span class="italic text-xs">Informasi PIC tersedia di detail</span>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-col justify-end gap-2">
                    <a href="{{ route('siswa.perusahaan.show', $item->id) }}" 
                        class="px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-blue-600 hover:text-white dark:text-slate-200 text-slate-700 text-xs font-bold rounded-lg transition-all text-center">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="py-12 text-center bg-gray-50 dark:bg-slate-900/50 rounded-2xl border-2 border-dashed border-gray-200 dark:border-slate-800">
            <p class="text-gray-500 dark:text-slate-400 font-medium">Data mitra belum tersedia atau tidak ditemukan.</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($perusahaan->hasPages())
    <div class="mt-8">
        {{ $perusahaan->links() }}
    </div>
    @endif
</x-app-layout>