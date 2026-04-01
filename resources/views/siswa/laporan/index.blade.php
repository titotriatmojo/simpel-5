<x-app-layout>
    {{-- Header Section --}}
    <div class="mb-8 bg-white/90 dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-2xl p-6 dark:shadow-lg">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Laporan PKL</h1>
                <p class="text-gray-500 dark:text-primary-n5 text-sm">Kelola file laporan dan tautan Google Drive Anda di sini.</p>
            </div>
        </div>
        <div class="mt-4">
            <div class="w-32 h-1 bg-gradient-to-r from-primary-n5 to-secondary-n5 rounded-full"></div>
        </div>
    </div>

    {{-- Alert Section --}}
    @if(session('success'))
    <div class="mb-6 bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 border border-emerald-500/20 px-4 py-3 rounded-xl text-sm flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{ editing: false }">
        {{-- Main Section --}}
        <div class="lg:col-span-2">
            
            {{-- Form Section: Muncul jika belum ada laporan, status ditolak, atau sedang mode editing --}}
            <div x-show="!{{ $laporan ? 'true' : 'false' }} || {{ ($laporan && $laporan->status === 'ditolak') ? 'true' : 'false' }} || editing" 
                 x-transition>
                <div class="backdrop-blur-sm bg-white/90 dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-2xl p-6 dark:shadow-xl">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Form Pengumpulan</h3>
                            <p class="text-xs text-gray-400 mt-1">Pastikan data sudah sesuai sebelum mengirim.</p>
                        </div>
                        <template x-if="editing">
                            <button @click="editing = false" class="text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </template>
                    </div>

                    <form action="{{ route('siswa.laporan.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        {{-- Perusahaan --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white">Perusahaan <span class="text-red-600">*</span></label>
                            <select name="perusahaan_id" required class="w-full bg-white/80 dark:bg-white/[0.05] text-gray-900 dark:text-white border border-gray-200 dark:border-white/20 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary-n5/50 outline-none transition-all">
                                <option value="">-- Pilih Perusahaan --</option>
                                @foreach($perusahaan as $item)
                                    <option value="{{ $item->id }}" {{ (old('perusahaan_id', $laporan->perusahaan_id ?? '') == $item->id) ? 'selected' : '' }}>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- File Upload --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white">File Laporan (Baru) <span class="text-xs text-gray-400 font-normal">(Kosongkan jika tidak ingin ganti file)</span></label>
                            <input name="file" type="file" class="block w-full text-sm text-gray-700 dark:text-slate-300 bg-white/80 dark:bg-white/[0.05] border border-gray-200 dark:border-white/20 rounded-xl file:mr-4 file:py-3 file:px-4 file:rounded-l-xl file:border-0 file:bg-primary-n5 file:text-white" />
                        </div>

                        {{-- Link Drive --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white">Link Google Drive <span class="text-red-600">*</span></label>
                            <input type="url" name="link_drive" required value="{{ old('link_drive', $laporan->link_drive ?? '') }}" placeholder="https://drive.google.com/..."
                                class="w-full bg-white/80 dark:bg-white/[0.05] border border-gray-200 dark:border-white/20 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-n5/50 outline-none transition-all" />
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-primary-n5 to-secondary-n5 text-white font-bold py-3 rounded-xl hover:scale-[1.01] transition-all">
                            {{ $laporan ? 'Perbarui Laporan' : 'Kirim Laporan Sekarang' }}
                        </button>
                    </form>
                </div>
            </div>

            {{-- Success/Waiting State View --}}
            @if($laporan && $laporan->status !== 'ditolak')
            <div x-show="!editing" class="backdrop-blur-sm bg-white/90 dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-2xl p-12 text-center shadow-xl">
                <div class="w-20 h-20 {{ $laporan->status === 'diterima' ? 'bg-emerald-500' : 'bg-amber-500' }} rounded-full flex items-center justify-center mx-auto mb-6 text-white shadow-lg">
                    @if($laporan->status === 'diterima')
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    @else
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    @endif
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Laporan Terkirim</h3>
                <p class="text-gray-500 mt-2 mb-8">Status saat ini: <span class="font-semibold text-indigo-500">{{ strtoupper($laporan->status) }}</span></p>
                
                <button @click="editing = true" class="px-6 py-2 bg-white dark:bg-white/10 border border-gray-200 dark:border-white/20 rounded-full text-sm font-medium text-gray-700 dark:text-white hover:bg-gray-50 transition-all">
                    Edit Link atau Upload Ulang
                </button>
            </div>
            @endif
        </div>

        {{-- Side Status Panel --}}
        <div class="lg:col-span-1">
            @if($laporan)
            <div class="backdrop-blur-sm bg-white/90 dark:bg-white/[0.03] border border-gray-200 dark:border-white/10 rounded-2xl p-6 shadow-xl sticky top-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Detail Pengiriman</h3>
                <div class="space-y-6 text-sm">
                    <div>
                        <span class="text-gray-400 block mb-1">Status</span>
                        <span class="px-2 py-1 rounded-md font-bold text-[10px] {{ $laporan->status === 'diterima' ? 'bg-green-500/20 text-green-500' : 'bg-amber-500/20 text-amber-500' }}">
                            {{ strtoupper($laporan->status) }}
                        </span>
                    </div>
                    <div class="pt-4 border-t border-gray-100 dark:border-white/5">
                        <span class="text-gray-400 block mb-2">File Saat Ini</span>
                       <a href="{{ route('siswa.laporan.download', $laporan->id) }}" class="text-blue-500 hover:underline flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            Download Laporan
                        </a>
                    </div>
                    <div class="pt-4 border-t border-gray-100 dark:border-white/5">
                        <span class="text-gray-400 block mb-2">Link Drive</span>
                        <a href="{{ $laporan->link_drive }}" target="_blank" class="text-indigo-500 hover:underline truncate block">
                            {{ $laporan->link_drive }}
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>