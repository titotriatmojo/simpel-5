<section x-data="{ showPasswords: false }"> <header class="relative space-y-4">
        <div class="relative z-10">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-br from-cyan-100 dark:from-cyan-500/20 to-blue-100 dark:to-blue-600/20 rounded-xl border border-cyan-200 dark:border-cyan-400/30">
                    <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="11" width="18" height="10" rx="2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M7 11V7a5 5 0 0110 0v4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-primary-n5 to-secondary-n5 dark:from-white dark:via-cyan-200 dark:to-blue-300 bg-clip-text text-transparent tracking-tight">
                        {{ __('Perbarui Kata Sandi') }}
                    </h2>
                    <div class="h-1 w-16 bg-gradient-to-r from-primary-n5 to-secondary-n5 rounded-full mt-2"></div>
                </div>
            </div>
        </div>
        
        <div class="flex items-center space-x-3 mt-4">
            <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Tampilkan Sandi') }}</span>
            <button type="button" 
                @click="showPasswords = !showPasswords"
                :class="showPasswords ? 'bg-cyan-500' : 'bg-gray-300 dark:bg-gray-600'"
                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                <span :class="showPasswords ? 'translate-x-5' : 'translate-x-0'"
                    class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
            </button>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6 mt-6">
        @csrf
        @method('put')

        <div class="space-y-5">
            <div class="space-y-2 relative">
                <x-input-label for="update_password_current_password" :value="__('Kata Sandi Saat Ini')" class="text-gray-900 dark:text-white font-medium text-sm" />
                <x-text-input id="update_password_current_password" name="current_password" 
                    ::type="showPasswords ? 'text' : 'password'"
                    class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/20 rounded-lg px-4 py-3 text-gray-900 dark:text-white"
                    autocomplete="current-password" placeholder="Masukkan kata sandi saat ini" />
                <x-input-error class="mt-2 text-red-500 text-sm" :messages="$errors->updatePassword->get('current_password')" />
            </div>

            <div class="space-y-2 relative">
                <x-input-label for="update_password_password" :value="__('Kata Sandi Baru')" class="text-gray-900 dark:text-white font-medium text-sm" />
                <x-text-input id="update_password_password" name="password" 
                    ::type="showPasswords ? 'text' : 'password'"
                    class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/20 rounded-lg px-4 py-3 text-gray-900 dark:text-white"
                    autocomplete="new-password" placeholder="Masukkan kata sandi baru (8 Digit)" />
                <x-input-error class="mt-2 text-red-500 text-sm" :messages="$errors->updatePassword->get('password')" />
            </div>

            <div class="space-y-2 relative">
                <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="text-gray-900 dark:text-white font-medium text-sm" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" 
                    ::type="showPasswords ? 'text' : 'password'"
                    class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/20 rounded-lg px-4 py-3 text-gray-900 dark:text-white"
                    autocomplete="new-password" placeholder="Ulangi kata sandi baru" />
                <x-input-error class="mt-2 text-red-500 text-sm" :messages="$errors->updatePassword->get('password_confirmation')" />
            </div>
        </div>

        <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-white/10">
            <x-primary-button class="px-6 py-3 bg-gradient-to-r from-emerald-400 to-green-500 rounded-xl text-white font-semibold">
                {{ __('Simpan') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-500 dark:text-emerald-400 ml-4">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>