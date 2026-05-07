<x-app-layout>
    {{-- Header Section --}}
    <div class="mb-8 bg-white dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-2xl p-6 shadow-none dark:shadow-lg">
        <div class="flex items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Kelola Format Laporan</h1>
                <p class="text-gray-600 dark:text-slate-400 text-sm">Upload dan kelola template format laporan PKL untuk siswa</p>
            </div>
        </div>
        <div class="mt-4">
            <div class="w-32 h-1 bg-gradient-to-r from-primary-n5 to-secondary-n5 rounded-full"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        {{-- Upload Form Section --}}
        <div class="xl:col-span-1">
            <div class="bg-white dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-2xl p-6 shadow-none dark:shadow-xl sticky top-6">
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-primary-n5 to-secondary-n5 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Upload Format</h3>
                            <p class="text-sm text-gray-500 dark:text-slate-400">Tambah template baru</p>
                        </div>
                    </div>
                    <div class="w-12 h-1 bg-gradient-to-r from-primary-n5 to-secondary-n5 rounded-full"></div>
                </div>

                <form action="{{ route('admin.format.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    {{-- Nama Format --}}
                    <div class="space-y-2">
                        <label for="nama" class="block text-sm font-semibold text-gray-900 dark:text-white">
                            Nama Format Laporan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" id="nama" required
                            class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/20 rounded-xl px-4 py-3 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-slate-400 focus:border-indigo-400/50 focus:bg-white/10 transition-all duration-200"
                            placeholder="Contoh: Template Laporan PKL 2026">
                        @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- File Upload --}}
                    <div class="space-y-2">
                        <label for="file" class="block text-sm font-semibold text-gray-900 dark:text-white">Upload File Template</label>
                        <div class="relative">
                            <input type="file" name="file" id="file" accept=".pdf,.doc,.docx"
                                class="block w-full text-sm text-gray-700 dark:text-slate-300 bg-white dark:bg-white/5 border border-gray-200 dark:border-white/20 rounded-xl cursor-pointer focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all duration-200 file:mr-4 file:py-3 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-semibold file:bg-gradient-to-r file:from-blue-600 file:to-cyan-600 file:text-white" />
                        </div>
                        @error('file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Link Google Drive --}}
                    <div class="space-y-2">
                        <label for="link_format" class="block text-sm font-semibold text-gray-900 dark:text-white">Atau Link Google Drive</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-emerald-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                            </div>
                            <input type="url" name="link_format" id="link_format"
                                class="w-full pl-11 bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/20 rounded-xl px-4 py-3 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-slate-400 focus:border-emerald-400/50 focus:bg-white/10 transition-all duration-200"
                                placeholder="https://drive.google.com/...">
                        </div>
                        <p class="text-[10px] text-gray-400 italic">Pilih salah satu atau isi keduanya.</p>
                                                <p class="text-[11px] text-amber-600 dark:text-amber-400 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Wajib menggunakan https:// (contoh: https://link.drive.google.com)
                        </p>
                        @error('link_format') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-2">
                        <button type="submit"
                            class="w-full group relative overflow-hidden bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white font-semibold py-3 px-6 rounded-xl transform hover:scale-[1.02] transition-all duration-200">
                            <span class="relative flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                Upload Format
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Format List Section --}}
        <div class="xl:col-span-2">
            <div class="bg-white dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-2xl shadow-none dark:shadow-xl overflow-hidden">
                {{-- Card Header --}}
                <div class="px-6 py-4 border-b border-gray-200 dark:border-white/10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-primary-n5 to-secondary-n5 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Format Laporan</h3>
                            <p class="text-sm text-gray-500 dark:text-slate-400">Template yang tersedia untuk siswa</p>
                        </div>
                    </div>
                </div>

                {{-- Table Content --}}
                <div class="overflow-x-auto">
                    @forelse ($format as $i => $file)
                        @if($loop->first)
                            <div class="hidden lg:grid lg:grid-cols-12 gap-4 px-6 py-3 bg-gray-50 dark:bg-white/[0.02] border-b border-gray-200 dark:border-white/10 text-xs font-semibold text-gray-700 dark:text-slate-300 uppercase tracking-wider">
                                <div class="col-span-1">No.</div>
                                <div class="col-span-5">Nama Template</div>
                                <div class="col-span-2">Berkas</div>
                                <div class="col-span-2">Tanggal</div>
                                <div class="col-span-2 text-center">Aksi</div>
                            </div>
                        @endif

                        <div class="group hover:bg-gray-100 dark:hover:bg-white/[0.02] transition-all duration-200 border-b border-gray-100 dark:border-white/5 last:border-b-0">
                            <div class="hidden lg:grid lg:grid-cols-12 gap-4 items-center px-6 py-4">
                                {{-- Number --}}
                                <div class="col-span-1">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 dark:bg-slate-700/50 text-gray-700 dark:text-slate-300 text-sm font-medium rounded-lg group-hover:bg-gray-200 dark:group-hover:bg-slate-600/50 transition-colors">
                                        {{ $i + 1 }}
                                    </span>
                                </div>

                                {{-- Template Name --}}
                                <div class="col-span-5 flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-gray-900 dark:text-white font-medium">{{ $file->nama }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">
                                            @if($file->file)
                                                {{ strtoupper(pathinfo($file->file, PATHINFO_EXTENSION)) }} File
                                            @else
                                                Cloud Link
                                            @endif
                                        </p>
                                    </div>
                                </div>

                {{-- File & Link --}}
                <div class="col-span-2">
                    <div class="flex flex-col gap-1.5">
                        @if($file->file)
                            <a href="{{ route('admin.format.download', $file->id) }}" 
                                class="inline-flex items-center gap-1.5 text-blue-600 dark:text-blue-400 hover:text-blue-800 text-xs font-medium transition-colors hover:underline">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download
                            </a>
                        @endif

                        @if($file->link_format)
                            <a href="{{ $file->link_format }}" target="_blank"
                                class="inline-flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 text-xs font-medium transition-colors hover:underline">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Buka Link
                            </a>
                        @endif
                    </div>
                </div>

                                {{-- Date --}}
                                <div class="col-span-2">
                                    <span class="text-xs text-gray-500 dark:text-slate-400">
                                        {{ $file->created_at->format('d M Y') }}
                                    </span>
                                </div>

                                {{-- Actions --}}
                                <div class="col-span-2 text-center">
                                    <form action="{{ route('admin.format.destroy', $file->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus template ini?')"
                                        class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 dark:bg-red-600/10 hover:bg-red-100 dark:hover:bg-red-600/20 text-red-600 dark:text-red-400 text-sm font-medium rounded-lg transition-all duration-200 border border-red-100 dark:border-red-500/20">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 dark:bg-slate-700/50 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-700 dark:text-slate-300 mb-2">Belum Ada Template</h3>
                            <p class="text-sm text-gray-500 dark:text-slate-400 max-w-sm mx-auto">Gunakan form di sebelah kiri untuk menambah template baru.</p>
                        </div>
                    @endforelse
                </div>

                @if(count($format) > 0)
                    <div class="px-6 py-4 bg-gray-50 dark:bg-white/[0.02] border-t border-gray-200 dark:border-white/10">
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Total {{ count($format) }} template tersedia</span>
                            </div>
                            <span class="hidden sm:block italic text-[11px]">Siswa dapat mengakses file-file ini di dashboard mereka.</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>