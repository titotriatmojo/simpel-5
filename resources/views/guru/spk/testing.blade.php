<x-app-layout>
    <div class="p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Uji Akurasi Sistem (K-NN)</h2>
            <p class="text-gray-600 dark:text-slate-400">Evaluasi performa algoritma menggunakan Confusion Matrix</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Statistik Utama --}}
            <div class="bg-white dark:bg-white/[0.03] p-6 rounded-2xl border border-gray-200 dark:border-white/10 shadow-sm">
                <p class="text-sm text-gray-500">Akurasi Sistem</p>
                <h3 class="text-3xl font-bold text-emerald-500">{{ $akurasi ?? 0 }}%</h3>
            </div>
            <div class="bg-white dark:bg-white/[0.03] p-6 rounded-2xl border border-gray-200 dark:border-white/10 shadow-sm">
                <p class="text-sm text-gray-500">Total Data Uji</p>
                <h3 class="text-3xl font-bold text-blue-500">{{ $totalDataUji ?? 0 }}</h3>
            </div>
            <div class="bg-white dark:bg-white/[0.03] p-6 rounded-2xl border border-gray-200 dark:border-white/10 shadow-sm">
                <p class="text-sm text-gray-500">Nilai K Terbaik</p>
                <h3 class="text-3xl font-bold text-purple-500">{{ $k_value ?? 5 }}</h3>
            </div>

            {{-- Confusion Matrix Table --}}
            <div class="md:col-span-2 bg-white dark:bg-white/[0.03] rounded-2xl border border-gray-200 dark:border-white/10 overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5">
                    <h4 class="font-semibold text-gray-800 dark:text-white">Confusion Matrix</h4>
                </div>
                <div class="p-8">
                    <div class="max-w-md mx-auto">
                        <table class="w-full border-collapse">
                                <thead>
                                    <tr>
                                        <th class="p-2"></th>
                                        <th class="p-2 text-center text-sm font-medium text-gray-500" colspan="2">Prediksi Sistem</th>
                                    </tr>
                                    <tr>
                                        <th class="p-2 text-sm font-medium text-gray-500 text-left">Aktual Data</th>
                                        <th class="p-4 bg-gray-100 dark:bg-white/10 border dark:border-white/20 text-gray-800 dark:text-white">Siap</th>
                                        <th class="p-4 bg-gray-100 dark:bg-white/10 border dark:border-white/20 text-gray-800 dark:text-white">Tidak Siap</th>
                                    </tr>
                                </thead>
                            <tbody>
                                <tr>
                                    <th class="p-4 bg-gray-100 dark:bg-white/10 border dark:border-white/20 text-sm font-medium text-gray-800 dark:text-white">Siap</th>
                                    <td class="p-6 border dark:border-white/20 text-center font-bold text-xl text-emerald-600 bg-emerald-50 dark:bg-emerald-500/10">
                                        {{ $tp ?? 0 }} <span class="block text-xs font-normal text-gray-400">(True Positive)</span>
                                    </td>
                                    <td class="p-6 border dark:border-white/20 text-center font-bold text-xl text-red-600">
                                        {{ $fn ?? 0 }} <span class="block text-xs font-normal text-gray-400">(False Negative)</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="p-4 bg-gray-100 dark:bg-white/10 border dark:border-white/20 text-sm font-medium text-gray-800 dark:text-white">Tidak Siap</th>
                                    <td class="p-6 border dark:border-white/20 text-center font-bold text-xl text-red-600">
                                        {{ $fp ?? 0 }} <span class="block text-xs font-normal text-gray-400">(False Positive)</span>
                                    </td>
                                    <td class="p-6 border dark:border-white/20 text-center font-bold text-xl text-emerald-600 bg-emerald-50 dark:bg-emerald-500/10">
                                        {{ $tn ?? 0 }} <span class="block text-xs font-normal text-gray-400">(True Negative)</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Rekomendasi/Action --}}
            <div class="bg-white dark:bg-white/[0.03] p-6 rounded-2xl border border-gray-200 dark:border-white/10 shadow-sm space-y-4">
                <h4 class="font-semibold text-gray-800 dark:text-white">Kontrol Pengujian</h4>
                <form action="{{ route('guru.spk.testing.proses') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm text-gray-500">Jumlah K Neighbors</label>
                            <input type="number" name="k" value="3" class="w-full mt-1 rounded-xl border-gray-200 dark:bg-white/10 dark:border-white/20 dark:text-white">
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Ratio Data Uji (%)</label>
                            <select name="ratio" class="w-full mt-1 rounded-xl border-gray-200 dark:bg-white/10 dark:border-white/20 dark:text-white">
                                <option value="0.2">20% Testing / 80% Training</option>
                                <option value="0.3">30% Testing / 70% Training</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-semibold transition-all">
                            Jalankan Uji Akurasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>