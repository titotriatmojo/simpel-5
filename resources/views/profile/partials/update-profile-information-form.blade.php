<section>
    <header class="relative space-y-4">
        <div class="relative z-10">
            <div class="flex items-center gap-3">
                <div
                    class="p-3 bg-gradient-to-br from-cyan-100 dark:from-cyan-500/20 to-blue-100 dark:to-blue-600/20 rounded-xl border border-cyan-200 dark:border-cyan-400/30">
                    <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <h2
                        class="text-3xl font-bold bg-gradient-to-r from-gray-900 via-cyan-600 to-blue-500 dark:from-white dark:via-cyan-200 dark:to-blue-300 bg-clip-text text-transparent tracking-tight">
                        {{ __('Informasi Profil') }}
                    </h2>
                    <div class="h-1 w-16 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full mt-2"></div>
                </div>
            </div>
        </div>
        <p class="mt-1 text-sm text-gray-700 dark:text-white/80">
            {{ __('Perbarui informasi profil dan data kontak darurat akun anda.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="space-y-5">
            <div class="space-y-2">
                <x-input-label for="name" :value="__('Nama Lengkap')"
                    class="text-gray-900 dark:text-white font-medium text-sm" />
                <x-text-input id="name" name="name" type="text"
                    class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/20 rounded-lg px-4 py-3 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-slate-400 focus:border-indigo-400/50 focus:bg-white/10 transition-all duration-200"
                    :value="old('name', $user->name)" required autofocus autocomplete="name"
                    placeholder="Masukkan nama lengkap" />
                <x-input-error class="mt-2 text-red-500 dark:text-red-400/90 text-sm"
                    :messages="$errors->get('name')" />
            </div>

            <div class="space-y-2">
                <x-input-label for="email" :value="__('Email')"
                    class="text-gray-900 dark:text-white font-medium text-sm" />
                <x-text-input id="email" name="email" type="email"
                    class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/20 rounded-lg px-4 py-3 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-slate-400 focus:border-indigo-400/50 focus:bg-white/10 transition-all duration-200"
                    :value="old('email', $user->email)" required autocomplete="username" placeholder="nama@email.com" />
                <x-input-error class="mt-2 text-red-500 dark:text-red-400/90 text-sm"
                    :messages="$errors->get('email')" />
            </div>

            <div class="space-y-2">
                <x-input-label for="no_hp_ortu" :value="__('No. Telepon Orang Tua / Wali')"
                    class="text-gray-900 dark:text-white font-medium text-sm" />
                <x-text-input id="no_hp_ortu" name="no_hp_ortu" type="text"
                    class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/20 rounded-lg px-4 py-3 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-slate-400 focus:border-indigo-400/50 focus:bg-white/10 transition-all duration-200"
                    :value="old('no_hp_ortu', $user->no_hp_ortu)" placeholder="Contoh: 081234567890" />
                <x-input-error class="mt-2 text-red-500 dark:text-red-400/90 text-sm"
                    :messages="$errors->get('no_hp_ortu')" />
            </div>

            <div class="space-y-2">
                <x-input-label for="alamat" :value="__('Alamat Lengkap')"
                    class="text-gray-900 dark:text-white font-medium text-sm" />
                <textarea id="alamat" name="alamat"
                    class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/20 rounded-lg px-4 py-3 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-slate-400 focus:border-indigo-400/50 focus:bg-white/10 transition-all duration-200 min-h-[100px]"
                    placeholder="Masukkan alamat tempat tinggal sekarang">{{ old('alamat', $user->alamat) }}</textarea>
                <x-input-error class="mt-2 text-red-500 dark:text-red-400/90 text-sm"
                    :messages="$errors->get('alamat')" />
            </div>
        </div>

        <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-white/10">
            <x-primary-button
                class="px-6 py-3 bg-gradient-to-r from-emerald-400 to-green-500 dark:from-emerald-500 dark:to-green-600 hover:from-emerald-500 hover:to-green-600 dark:hover:from-emerald-600 dark:hover:to-green-700 rounded-xl text-white font-semibold shadow-md dark:shadow-lg hover:shadow-lg dark:hover:shadow-xl transition-all duration-200 flex items-center space-x-2 group">
                <svg class="w-5 h-5 transition-transform duration-200 group-hover:rotate-12" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ __('Simpan Perubahan') }}</span>
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-600 dark:text-emerald-400 font-medium"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>