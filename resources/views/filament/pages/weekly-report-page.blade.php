<x-filament-panels::page>
    <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="fi-section-header flex flex-col gap-3 px-6 py-4 sm:flex-row sm:items-center">
            <div class="grid gap-y-1">
                <h2 class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                    Input Laporan Membaca Mingguan
                </h2>
                <p class="fi-section-header-description text-sm text-gray-500 dark:text-gray-400">
                    Isi progres membaca untuk setiap siswa di kelas Anda. Kosongkan baris jika siswa tidak melapor.
                </p>
            </div>
        </div>
        <div class="fi-section-content-ctn p-6">
            {{-- Tabel untuk input data --}}
            <div class="overflow-x-auto">
                <table class="fi-table w-full text-start divide-y divide-gray-200 dark:divide-white/5">
                    <thead class="bg-gray-50 dark:bg-white/5">
                        <tr>
                            <th class="fi-table-header-cell px-3 py-3.5 sm:px-6">Nama Siswa</th>
                            <th class="fi-table-header-cell px-3 py-3.5 sm:px-6">Judul Buku</th>
                            <th class="fi-table-header-cell px-3 py-3.5 sm:px-6">Status</th>
                            <th class="fi-table-header-cell px-3 py-3.5 sm:px-6">Hal. Terakhir</th>
                            <th class="fi-table-header-cell px-3 py-3.5 sm:px-6">Total Hal.</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-white/5 whitespace-nowrap">
                        @forelse ($logs as $index => $log)
                            <tr>
                                <td class="fi-table-cell px-3 py-4 sm:px-6">{{ $log['student_name'] }}</td>
                                <td class="fi-table-cell px-3 py-4 sm:px-6">
                                    <input type="text" wire:model.blur="logs.{{ $index }}.book_title" class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600">
                                </td>
                                <td class="fi-table-cell px-3 py-4 sm:px-6">
                                    <select wire:model.blur="logs.{{ $index }}.status" class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600">
                                        <option value="Sedang Dibaca">Sedang Dibaca</option>
                                        <option value="Selesai">Selesai</option>
                                    </select>
                                </td>
                                <td class="fi-table-cell px-3 py-4 sm:px-6">
                                    <input type="number" wire:model.blur="logs.{{ $index }}.last_page_read" class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600">
                                </td>
                                <td class="fi-table-cell px-3 py-4 sm:px-6">
                                    <input type="number" wire:model.blur="logs.{{ $index }}.total_pages" class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="fi-table-cell px-3 py-4 sm:px-6 text-center">Tidak ada siswa di kelas Anda atau Anda bukan wali kelas untuk tahun ajaran ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Tombol Simpan --}}
            <div class="mt-6">
                <button type="button" wire:click="saveLogs" class="fi-btn fi-btn-size-md fi-btn-color-primary">
                    Simpan Semua Laporan
                </button>
            </div>
        </div>
    </div>
</x-filament-panels::page>