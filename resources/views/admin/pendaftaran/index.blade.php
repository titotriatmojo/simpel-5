<x-app-layout>
    {{-- Header Section --}}
    <div class="mb-8 bg-white dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-2xl p-6 shadow-none dark:shadow-lg">
        <div class="flex items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Verifikasi Pendaftaran PKL</h1>
                <p class="text-gray-900 dark:text-blue-100 text-sm">Tinjau, ubah status, atau hapus data pendaftaran siswa.</p>
            </div>
        </div>
        <div class="mt-4">
            <div class="w-32 h-1 bg-gradient-to-r from-primary-n5 to-secondary-n5 rounded-full"></div>
        </div>
    </div>

    {{-- Area Tombol & Search --}}
    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.pendaftaran.index') }}" class="flex items-center gap-3 h-[48px]">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari Nama, NISN, Perusahaan, Status..."
                class="h-[48px] px-4 py-2 rounded-lg border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-blue-400 focus:outline-none text-sm w-96 dark:bg-slate-800 dark:text-white transition-all duration-200 shadow-sm"
                autocomplete="off">
            <button type="submit"
                class="h-[48px] w-[48px] flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all duration-200 shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
            @if(request('search'))
            <a href="{{ route('admin.pendaftaran.index') }}" class="text-sm text-gray-500 dark:text-slate-300 underline ml-2">Reset</a>
            @endif
        </form>
    </div>

    {{-- Tabel --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50 dark:bg-slate-700/30 dark:border-white/10">
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase">No.</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase">Nama Siswa</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase">Perusahaan</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                    @forelse ($pendaftaran as $index => $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-400">
                            {{ $pendaftaran->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $item->siswa->nama }}</div>
                            <div class="text-xs text-gray-500 dark:text-slate-500">{{ $item->siswa->nim }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700 dark:text-slate-300">
                            {{ $item->perusahaan->nama }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusStyles = [
                                    'menunggu' => 'bg-amber-100 text-amber-700 border-amber-200 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20',
                                    'diterima' => 'bg-emerald-100 text-emerald-700 border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20',
                                    'ditolak' => 'bg-rose-100 text-rose-700 border-rose-200 dark:bg-rose-500/10 dark:text-rose-400 dark:border-rose-500/20',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusStyles[$item->status] ?? '' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm" x-data="{ editing: false }">
                            <div class="flex items-center gap-3">
                                {{-- MODE EDIT / VERIFIKASI --}}
                                <template x-if="{{ $item->status === 'menunggu' ? 'true' : 'false' }} || editing">
                                    <form action="{{ route('admin.pendaftaran.verifikasi', $item->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        <select name="status" class="bg-gray-50 dark:bg-slate-800 border border-gray-300 dark:border-white/10 rounded-lg px-2 py-1.5 text-xs text-gray-700 dark:text-white focus:ring-blue-500 transition-all">
                                            <option value="menunggu" {{ $item->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                            <option value="diterima" {{ $item->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                            <option value="ditolak" {{ $item->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                        <button type="submit" class="p-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg transition-colors" title="Simpan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                        <button type="button" @click="editing = false" class="p-2 bg-gray-200 dark:bg-white/10 text-gray-600 dark:text-gray-400 rounded-lg hover:bg-gray-300 transition-colors" title="Batal">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </form>
                                </template>

                                {{-- MODE NORMAL --}}
                                <template x-if="{{ $item->status !== 'menunggu' ? 'true' : 'false' }} && !editing">
                                    <button @click="editing = true" class="p-2 bg-amber-100 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-lg hover:bg-amber-200 transition-colors" title="Ubah Status">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                </template>

                                {{-- TOMBOL TRASH (DELETE) --}}
                                <form action="{{ route('admin.pendaftaran.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus pendaftaran {{ $item->siswa->nama }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-rose-100 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 rounded-lg hover:bg-rose-200 transition-colors" title="Hapus Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400">Belum ada data pendaftaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if(method_exists($pendaftaran, 'hasPages') && $pendaftaran->hasPages())
    <div class="mt-6 flex items-center justify-between">
        <p class="text-sm text-gray-500 dark:text-slate-400">
            Menampilkan {{ $pendaftaran->firstItem() }} - {{ $pendaftaran->lastItem() }} dari {{ $pendaftaran->total() }} pendaftaran
        </p>
        <div class="flex gap-2">
            {{ $pendaftaran->links() }}
        </div>
    </div>
    @endif
</x-app-layout>