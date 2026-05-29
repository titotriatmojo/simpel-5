<x-app-layout>
    <div class="p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                Uji Akurasi Sistem (K-NN)
            </h2>
            <p class="text-gray-600 dark:text-slate-400">
                Evaluasi performa model menggunakan Confusion Matrix dengan nilai K = {{ $k_value ?? 3 }}
            </p>
            <p class="text-gray-600 dark:text-slate-400 text-sm mt-1">
                Sistem diuji menggunakan 5-Fold Cross Validation, membagi dataset secara proporsional ke dalam 5 bagian (fold).
            </p>
        </div>

        {{-- GRID METRIK STATISTIK UTAMA --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
            <div class="bg-white dark:bg-white/[0.03] p-4 rounded-2xl border shadow-sm">
                <p class="text-xs font-medium text-gray-400 uppercase">Akurasi</p>
                <h3 class="text-2xl font-bold text-emerald-500 mt-1">
                    {{ $akurasi ?? 0 }}%
                </h3>
            </div>

            <div class="bg-white dark:bg-white/[0.03] p-4 rounded-2xl border shadow-sm">
                <p class="text-xs font-medium text-gray-400 uppercase">Precision</p>
                <h3 class="text-2xl font-bold text-blue-500 mt-1">
                    {{ $precision ?? 0 }}%
                </h3>
            </div>

            <div class="bg-white dark:bg-white/[0.03] p-4 rounded-2xl border shadow-sm">
                <p class="text-xs font-medium text-gray-400 uppercase">Recall</p>
                <h3 class="text-2xl font-bold text-indigo-500 mt-1">
                    {{ $recall ?? 0 }}%
                </h3>
            </div>

            <div class="bg-white dark:bg-white/[0.03] p-4 rounded-2xl border shadow-sm">
                <p class="text-xs font-medium text-gray-400 uppercase">Specificity</p>
                <h3 class="text-2xl font-bold text-orange-500 mt-1">
                    {{ $specificity ?? 0 }}%
                </h3>
            </div>

            <div class="bg-white dark:bg-white/[0.03] p-4 rounded-2xl border shadow-sm">
                <p class="text-xs font-medium text-gray-400 uppercase">F1-Score</p>
                <h3 class="text-2xl font-bold text-pink-500 mt-1">
                    {{ $f1_score ?? 0 }}%
                </h3>
            </div>

            <div class="bg-white dark:bg-white/[0.03] p-4 rounded-2xl border shadow-sm">
                <p class="text-xs font-medium text-gray-400 uppercase">Data Uji / K</p>
                <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300 mt-1">
                    {{ $totalDataUji ?? 0 }} <span class="text-xs font-normal text-gray-400">data (K={{ $k_value ?? 3 }})</span>
                </h3>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- CONFUSION MATRIX TABLE --}}
            <div class="lg:col-span-2 bg-white dark:bg-white/[0.03] rounded-2xl border overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b bg-gray-50 dark:bg-white/5">
                    <h4 class="font-semibold text-gray-800 dark:text-white">
                        Confusion Matrix Table
                    </h4>
                </div>

                <div class="p-6">
                    <div class="max-w-md mx-auto my-4">
                        <table class="w-full border-collapse text-sm">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th colspan="2" class="text-center text-gray-500 pb-2 font-semibold uppercase tracking-wider text-xs">
                                        Kelas Prediksi
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-left text-gray-500 font-semibold uppercase tracking-wider text-xs">Kelas Aktual</th>
                                    <th class="p-3 border bg-gray-100 dark:bg-white/10 font-bold text-gray-700 dark:text-gray-300">Siap</th>
                                    <th class="p-3 border bg-gray-100 dark:bg-white/10 font-bold text-gray-700 dark:text-gray-300">Tidak Siap</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <th class="p-3 border bg-gray-100 dark:bg-white/10 text-left font-bold text-gray-700 dark:text-gray-300">Siap</th>

                                    {{-- TP --}}
                                    <td class="p-5 border text-center text-xl font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-500/10">
                                        {{ $tp ?? 0 }}
                                        <span class="block text-xs font-normal text-emerald-500 dark:text-emerald-400/70 mt-1">True Positive (TP)</span>
                                    </td>

                                    {{-- FN --}}
                                    <td class="p-5 border text-center text-xl font-bold text-red-600 bg-red-50/30 dark:bg-red-500/5">
                                        {{ $fn ?? 0 }}
                                        <span class="block text-xs font-normal text-red-400 mt-1">False Negative (FN)</span>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="p-3 border bg-gray-100 dark:bg-white/10 text-left font-bold text-gray-700 dark:text-gray-300">Tidak Siap</th>

                                    {{-- FP --}}
                                    <td class="p-5 border text-center text-xl font-bold text-red-600 bg-red-50/30 dark:bg-red-500/5">
                                        {{ $fp ?? 0 }}
                                        <span class="block text-xs font-normal text-red-400 mt-1">False Positive (FP)</span>
                                    </td>

                                    {{-- TN --}}
                                    <td class="p-5 border text-center text-xl font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-500/10">
                                        {{ $tn ?? 0 }}
                                        <span class="block text-xs font-normal text-emerald-500 dark:text-emerald-400/70 mt-1">True Negative (TN)</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- PANEL KONTROL UJI --}}
            <div class="bg-white dark:bg-white/[0.03] p-6 rounded-2xl border shadow-sm flex flex-col justify-between">
                <div>
                    <h4 class="font-semibold text-gray-800 dark:text-white mb-2">
                        Kontrol Pengujian
                    </h4>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mb-6 leading-relaxed">
                        Klik tombol di bawah untuk memicu pembagian K-Fold validation secara internal, melakukan komparasi jarak Euclidean, dan menghitung ulang seluruh matriks performa sistem klasifikasi.
                    </p>
                </div>

                <form action="{{ route('guru.spk.testing.proses') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full py-3 bg-emerald-500 hover:bg-emerald-600 transition-colors duration-200 text-white rounded-xl font-semibold shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                        Jalankan Validasi Sistem
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>