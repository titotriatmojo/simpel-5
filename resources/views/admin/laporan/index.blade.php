<x-app-layout>
    {{-- Header Section --}}
    <div class="mb-8 bg-white dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-2xl p-6 shadow-none dark:shadow-lg">
        <div class="flex items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Verifikasi Laporan PKL</h1>
                <p class="text-gray-600 dark:text-blue-100 text-sm">Tinjau, ubah status verifikasi, atau kelola laporan siswa.</p>
            </div>
        </div>
        <div class="mt-4">
            <div class="w-32 h-1 bg-gradient-to-r from-primary-n5 to-secondary-n5 rounded-full"></div>
        </div>
    </div>

    {{-- Pesan sukses --}}
    @if (session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
        class="mb-6 bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-500/30 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-3">
        <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Search Area --}}

    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.laporan.verifikasi') }}" class="flex items-center gap-3 h-[48px]">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama, NISN, Status..."
                class="h-[48px] px-4 py-2 rounded-lg border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-blue-400 focus:outline-none text-sm w-80 dark:bg-slate-800 dark:text-white transition-all shadow-sm"
                autocomplete="off">
            <button type="submit" class="h-[48px] w-[48px] flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" stroke-linecap="round" />
                </svg>
            </button>

            @if(request('search'))
                <a href="{{ route('admin.laporan.verifikasi') }}" class="text-sm text-gray-500 underline">Reset</a>
            @endif
        </form>
    </div>

    {{-- Tabel Utama --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b bg-gray-50 dark:bg-slate-700/30 border-gray-200 dark:border-white/10 text-left">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-slate-200 uppercase tracking-wider">No.</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-slate-200 uppercase tracking-wider">Identitas Siswa</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-slate-200 uppercase tracking-wider">Akses Berkas</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-slate-200 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-slate-200 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                    @forelse ($laporan as $index => $lapor)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                        {{-- No --}}
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-300">
                            {{ $laporan->firstItem() + $index }}
                        </td>
                    
                        {{-- Siswa --}}
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $lapor->siswa->nama }}</div>
                            <div class="text-xs text-gray-500 dark:text-slate-400">NISN: {{ $lapor->siswa->nim }}</div>
                        </td>

                        {{-- Link Drive & File --}}
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-2">
                                @if($lapor->file)
                                <a href="{{ route('admin.laporan.download', $lapor->id) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Download PDF/DOC
                                </a>
                                @endif

                                @if($lapor->link_drive)
                                <a href="{{ $lapor->link_drive }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    Link Google Drive
                                </a>

                                @else
                                <span class="text-[10px] text-gray-400 italic font-medium uppercase">Drive Tidak Ada</span>
                                @endif
                            </div>
                        </td>

                        {{-- Status Badge --}}
                        <td class="px-6 py-4">
                            @php
                                $badge = [

                                    'pending' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 border-amber-200',

                                    'diterima' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 border-emerald-200',

                                    'ditolak' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400 border-rose-200',

                                ];

                            @endphp

                            <span class="px-2 py-1 rounded-full text-[10px] font-black border uppercase {{ $badge[$lapor->status] ?? 'bg-gray-100 text-gray-600' }}">

                                {{ $lapor->status }}

                            </span>

                        </td>



                        {{-- AKSI (Edit Status & Hapus) --}}

                       <td class="px-6 py-4">
    <div class="flex items-center justify-center gap-4">
        {{-- Tombol Edit Status (Dropdown) --}}
        <div x-data="{ open: false }" class="relative">
            {{-- Tombol Trigger --}}
            <button @click="open = !open" 
                class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-500/10 rounded-lg transition-all focus:outline-none" 
                title="Ubah Status">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </button>

            {{-- Dropdown Menu: Melayang (Absolute) --}}
            <div x-show="open" 
                @click.away="open = false" 
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                {{-- z-50 supaya di atas, absolute biar gak ngerusak layout --}}
                class="absolute right-0 mt-2 w-40 bg-white dark:bg-slate-800 border border-gray-200 dark:border-white/10 rounded-xl shadow-2xl z-[100] overflow-hidden origin-top-right">
                
                <form action="{{ route('admin.laporan.verifikasi.process', $lapor->id) }}" method="POST">
                    @csrf
                    <button type="submit" name="status" value="diterima" 
                        class="w-full text-left px-4 py-2.5 text-xs font-bold text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 border-b border-gray-100 dark:border-white/5 transition-colors">
                        Set Terima
                    </button>
                    <button type="submit" name="status" value="ditolak" 
                        class="w-full text-left px-4 py-2.5 text-xs font-bold text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors">
                        Set Tolak
                    </button>
                </form>
            </div>
        </div>

        {{-- Tombol Hapus --}}
        <form action="{{ route('admin.laporan.destroy', $lapor->id) }}" method="POST" onsubmit="return confirm('Hapus permanen laporan ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-lg transition-all" title="Hapus Laporan">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </form>
    </div>
</td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">Belum ada laporan masuk.</td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>



    {{-- Pagination --}}

    @if($laporan->hasPages())

    <div class="mt-6">

        {{ $laporan->links() }}

    </div>

    @endif

</x-app-layout>



