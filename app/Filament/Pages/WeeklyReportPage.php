<?php

namespace App\Filament\Pages;

use App\Models\ReadingLog;
use App\Models\Student;
use App\Services\CurrentAcademicYearService;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;

class WeeklyReportPage extends Page implements HasForms
{
    use InteractsWithForms, HasPageShield;

    // Nama file view yang akan digunakan
    protected static string $view = 'filament.pages.weekly-report-page';

    // Icon dan Judul Halaman di Navigasi
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $title = 'Weekly Report Input';
    protected static ?string $navigationLabel = 'Weekly Report Input';
    protected static ?string $navigationGroup = 'Literacy';

    // Properti untuk menyimpan data log yang akan diisi guru
    public ?array $logs = [];

    // public static function canAccess(): bool
    // {
    //     return auth()->user()?->can('page_WeeklyReportPage');
    // }

    // Method ini berjalan saat halaman pertama kali dimuat
    public function mount(): void
    {
        $this->loadStudentLogs();
    }

    // Fungsi untuk memuat data siswa dan log yang sudah ada untuk minggu ini
    protected function loadStudentLogs(): void
    {
        $user = auth()->user();
        $this->logs = []; // Kosongkan dulu

        // Pastikan user adalah guru dan punya kelas
        if ($user->hasRole('guru') && $user->teacher) {
            $activeYearId = (new CurrentAcademicYearService())->id();
            $classSection = $user->teacher->homeroomClasses()->where('academic_year_id', $activeYearId)->first();

            if ($classSection) {
                // Ambil semua siswa di kelasnya
                $students = $classSection->students()->orderBy('full_name')->get();

                // Tanggal laporan untuk minggu ini (kita ambil hari ini sebagai acuan)
                $reportDate = now()->toDateString();

                foreach ($students as $student) {
                    // Cek apakah sudah ada log untuk siswa ini pada tanggal ini
                    $existingLog = ReadingLog::where('student_id', $student->id)
                                                ->where('date_reported', $reportDate)
                                                ->first();

                    // Siapkan data untuk diisi di form
                    $this->logs[] = [
                        'student_id' => $student->id,
                        'student_name' => $student->full_name,
                        'book_title' => $existingLog?->book_title ?? '',
                        'status' => $existingLog?->status ?? 'Sedang Dibaca',
                        'last_page_read' => $existingLog?->last_page_read ?? '',
                        'total_pages' => $existingLog?->total_pages ?? '',
                        'date_reported' => $reportDate,
                    ];
                }
            }
        }
    }

    // Method yang akan dipanggil saat tombol "Simpan Semua" diklik
    public function saveLogs()
    {
        $activeYearId = (new CurrentAcademicYearService())->id();

        foreach ($this->logs as $logData) {
            // Hanya simpan jika judul buku diisi
            if (!empty($logData['book_title'])) {
                // Gunakan updateOrCreate untuk membuat data baru atau mengupdate jika sudah ada
                ReadingLog::updateOrCreate(
                    // Kunci untuk mencari record yang sudah ada
                    [
                        'student_id' => $logData['student_id'],
                        'date_reported' => $logData['date_reported'],
                    ],
                    // Data yang akan diisi atau diupdate
                    [
                        'academic_year_id' => $activeYearId,
                        'book_title' => $logData['book_title'],
                        'status' => $logData['status'],
                        'last_page_read' => $logData['last_page_read'] ?: null, // Simpan null jika kosong
                        'total_pages' => $logData['total_pages'] ?: null, // Simpan null jika kosong
                    ]
                );
            }
        }
        
        // Tampilkan notifikasi sukses
        Notification::make()
            ->title('Laporan berhasil disimpan')
            ->success()
            ->send();
    }
}