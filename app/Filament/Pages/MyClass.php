<?php

namespace App\Filament\Pages;

use App\Filament\Resources\StudentResource;
use App\Models\Student;
use App\Services\CurrentAcademicYearService;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

// Implementasikan HasTable dan gunakan trait InteractsWithTable
class MyClass extends Page implements HasTable
{
    use InteractsWithTable, HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    // Judul dan label menu navigasi
    protected static ?string $title = 'Daftar Siswa Kelas Saya';
    protected static ?string $navigationLabel = 'Daftar Siswa';

    // Kelompokkan di bawah menu "Kelas Saya"
    protected static ?string $navigationGroup = 'Kelas Saya';
    
    // Nama file view yang akan digunakan
    protected static string $view = 'filament.pages.my-class';

    /**
     * Method inti untuk mendefinisikan query data tabel.
     * Hanya akan mengambil siswa dari kelas yang diampu oleh guru yang login
     * untuk tahun ajaran yang aktif.
     */
    protected function getTableQuery(): Builder
    {
        $user = Auth::user();

        // Dapatkan ID tahun ajaran aktif dari service
        $activeYearId = (new CurrentAcademicYearService())->id();

        // Dapatkan rombel (kelas) yang diampu guru saat ini
        $classSection = $user->teacher?->homeroomClasses()
            ->where('academic_year_id', $activeYearId)
            ->first();

        // Jika guru punya kelas, ambil query relasi siswanya
        if ($classSection) {
            return $classSection->students()->getQuery();
        }

        // Jika guru tidak punya kelas, kembalikan query kosong
        return Student::query()->where('id', 0);
    }
    
    /**
     * Method untuk mendefinisikan kolom-kolom yang akan ditampilkan di tabel.
     */
    protected function getTableColumns(): array
    {
        return [
            ImageColumn::make('photo_url')
                ->label('Photo')
                ->circular(),
            
            TextColumn::make('full_name')
                ->searchable()
                ->sortable(),
            
            TextColumn::make('nisn')
                ->label('NISN')
                ->searchable(),
            
            TextColumn::make('gender'),
        ];
    }
    
    /**
     * Method untuk mendefinisikan aksi yang bisa dilakukan pada setiap baris tabel.
     */
    protected function getTableActions(): array
    {
        return [
            // Aksi untuk melihat detail profil literasi siswa
            ViewAction::make('view_profile')
                ->label('Lihat Profil Literasi')
                // Arahkan ke halaman view dari StudentResource
                ->url(fn (Student $record): string => StudentResource::getUrl('edit', ['record' => $record]))
        ];
    }
}