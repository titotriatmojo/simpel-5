<x-app-layout>
    {{-- Header Section --}}
    <div class="mb-8 bg-white/90 dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-2xl p-6 ">
        <div class="flex items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Format Laporan</h1>
                <p class="text-gray-600 dark:text-slate-400 text-sm">Download template dan format laporan yang telah disediakan untuk memudahkan penyusunan laporan PKL Anda</p>
            </div>
        </div>
        <div class="mt-4">
            <div class="w-32 h-1 bg-gradient-to-r from-primary-n5 to-secondary-n5 rounded-full"></div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="backdrop-blur-sm bg-white/90 dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-2xl overflow-hidden">
        {{-- Card Header --}}
        <div class="px-6 py-4 border-b border-gray-200 dark:border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-r from-primary-n5 to-secondary-n5 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Template Laporan</h3>
                    <p class="text-sm text-gray-500 dark:text-slate-400">Daftar format laporan yang tersedia</p>
                </div>
            </div>
        </div>

        {{-- Table Content --}}
        <div class="overflow-x-auto">
            @forelse ($format as $i => $file)
                @if($loop->first)
                    {{-- Table Header --}}
                    <div class="hidden md:grid md:grid-cols-12 gap-4 px-6 py-3 bg-gray-100/80 dark:bg-white/[0.02] border-b border-gray-200 dark:border-white/10 text-xs font-semibold text-gray-700 dark:text-slate-300 uppercase tracking-wider">
                        <div class="col-span-1">No.</div>
                        <div class="col-span-6">Nama File</div>
                        <div class="col-span-3">Diupload Pada</div>
                        <div class="col-span-2 text-center">Aksi</div>
                    </div>
                @endif

                {{-- Table Row --}}
                <div class="group hover:bg-gray-100/60 dark:hover:bg-white/[0.02] transition-all duration-200 border-b border-gray-100 dark:border-white/5 last:border-b-0">
                    <div class="hidden md:grid md:grid-cols-12 gap-4 items-center px-6 py-4">
                        {{-- Number --}}
                        <div class="col-span-1">
                            <span class="inline-flex items-center justify-center w-8 h-8 dark:bg-slate-700/50 text-gray-700 dark:text-slate-300 text-sm font-medium rounded-lg">
                                {{ $i + 1 }}
                            </span>
                        </div>

                        {{-- File Name & Info --}}
                        <div class="col-span-6 flex items-center gap-3">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-emerald-400 to-teal-400 dark:from-emerald-500 dark:to-teal-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-900 dark:text-white font-medium">{{ $file->nama }}</p>
                                <p class="text-[11px] text-gray-500 dark:text-slate-500 italic uppercase">
                                    @if($file->file)
                                        {{ pathinfo($file->file, PATHINFO_EXTENSION) }} Document
                                    @else
                                        Cloud Storage Link
                                    @endif
                                </p>
                            </div>
                        </div>

                        {{-- Tanggal Upload --}}
                        <div class="col-span-3 text-sm text-gray-600 dark:text-slate-400">
                            {{ $file->created_at->format('d M Y, H:i') }}
                        </div>

                        {{-- Actions --}}
                        <div class="col-span-2 flex flex-col gap-2">
                            {{-- Button Unduh File --}}
                            @if($file->file)
                                <a href="{{ asset('storage/' . $file->file) }}" target="_blank"
                                    class="inline-flex items-center justify-center gap-2 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition-all shadow-sm hover:shadow-blue-500/20">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Unduh File
                                </a>
                            @endif

                            {{-- Button Link Drive --}}
                            @if($file->link_format)
                                <a href="{{ $file->link_format }}" target="_blank"
                                    class="inline-flex items-center justify-center gap-2 px-3 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold rounded-lg transition-all shadow-sm hover:shadow-emerald-500/20">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    Buka Link
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                {{-- Empty State --}}
                <div class="px-6 py-12 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gray-200 dark:bg-slate-700/50 rounded-full flex items-center justify-center text-gray-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-700 dark:text-slate-300 mb-2">Belum Ada Format Laporan</h3>
                    <p class="text-sm text-gray-500 dark:text-slate-400 max-w-sm mx-auto">Template format laporan belum tersedia saat ini. Silakan hubungi admin.</p>
                </div>
            @endforelse
        </div>

        {{-- Footer Info --}}
        @if(count($format) > 0)
            <div class="px-6 py-4 bg-gray-100/80 dark:bg-white/[0.02] border-t border-gray-200 dark:border-white/10 flex items-center justify-between text-xs text-gray-500">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Total {{ count($format) }} format tersedia</span>
                </div>
            </div>
        @endif
    </div>

    {{-- Help Section --}}
    <div class="mt-6 backdrop-blur-sm bg-white/90 dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-2xl p-6">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-amber-400 to-orange-400 rounded-lg flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Panduan Penggunaan</h4>
                <ul class="text-sm text-gray-700 dark:text-slate-300 space-y-2">
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                        <span>Klik <b>Unduh File</b> untuk mendapatkan file template langsung.</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        <span>Klik <b>Buka Link</b> jika file berada di Google Drive atau Cloud lainnya.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>