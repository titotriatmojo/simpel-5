<x-app-layout>
    <div class="p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                Uji Akurasi Sistem (K-NN)
            </h2>
            <p class="text-gray-600 dark:text-slate-400">
                Evaluasi performa model menggunakan Confusion Matrix dengan nilai K = 3
            </p>
            <p class="text-gray-600 dark:text-slate-400">
                Sistem diuji menggunakan 5-Fold Cross Validation, yang berarti dataset dibagi secara proporsional ke dalam 5 bagian (fold).        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Statistik --}}
            <div class="bg-white dark:bg-white/[0.03] p-6 rounded-2xl border shadow-sm">
                <p class="text-sm text-gray-500">Akurasi</p>
                <h3 class="text-3xl font-bold text-emerald-500">
                    {{ $akurasi ?? 0 }}%
                </h3>
            </div>

            <div class="bg-white dark:bg-white/[0.03] p-6 rounded-2xl border shadow-sm">
                <p class="text-sm text-gray-500">Jumlah Data Uji</p>
                <h3 class="text-3xl font-bold text-blue-500">
                    {{ $totalDataUji ?? 0 }}
                </h3>
            </div>

            <div class="bg-white dark:bg-white/[0.03] p-6 rounded-2xl border shadow-sm">
                <p class="text-sm text-gray-500">Nilai K</p>
                <h3 class="text-3xl font-bold text-purple-500">
                    3
                </h3>
            </div>

            {{-- CONFUSION MATRIX --}}
            <div class="md:col-span-2 bg-white dark:bg-white/[0.03] rounded-2xl border overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b bg-gray-50 dark:bg-white/5">
                    <h4 class="font-semibold text-gray-800 dark:text-white">
                        Confusion Matrix
                    </h4>
                </div>

                <div class="p-8">
                    <div class="max-w-md mx-auto">
                        <table class="w-full border-collapse text-sm">

                            <thead>
                                <tr>
                                    <th></th>
                                    <th colspan="2" class="text-center text-gray-500">
                                        Prediksi
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-left text-gray-500">Aktual</th>
                                    <th class="p-3 border bg-gray-100 dark:bg-white/10">Siap</th>
                                    <th class="p-3 border bg-gray-100 dark:bg-white/10">Tidak Siap</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <th class="p-3 border bg-gray-100 dark:bg-white/10">Siap</th>

                                    {{-- TP --}}
                                    <td class="p-5 border text-center text-xl font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-500/10">
                                        {{ $tp ?? 0 }}
                                        <span class="block text-xs text-gray-400">TP</span>
                                    </td>

                                    {{-- FN --}}
                                    <td class="p-5 border text-center text-xl font-bold text-red-600">
                                        {{ $fn ?? 0 }}
                                        <span class="block text-xs text-gray-400">FN</span>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="p-3 border bg-gray-100 dark:bg-white/10">Tidak Siap</th>

                                    {{-- FP --}}
                                    <td class="p-5 border text-center text-xl font-bold text-red-600">
                                        {{ $fp ?? 0 }}
                                        <span class="block text-xs text-gray-400">FP</span>
                                    </td>

                                    {{-- TN --}}
                                    <td class="p-5 border text-center text-xl font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-500/10">
                                        {{ $tn ?? 0 }}
                                        <span class="block text-xs text-gray-400">TN</span>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

            {{-- CONTROL --}}
            <div class="bg-white dark:bg-white/[0.03] p-6 rounded-2xl border shadow-sm">
                <h4 class="font-semibold text-gray-800 dark:text-white mb-4">
                    Pengujian
                </h4>

                <form action="{{ route('guru.spk.testing.proses') }}" method="POST">
                    @csrf

                    <div class="space-y-4">

                        <button type="submit"
                            class="w-full py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-semibold">
                            Jalankan Uji
                        </button>

                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>