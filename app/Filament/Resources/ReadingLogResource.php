<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReadingLogResource\Pages;
use App\Filament\Resources\ReadingLogResource\RelationManagers;
use App\Models\ReadingLog;
use App\Services\CurrentAcademicYearService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReadingLogResource extends Resource
{
    protected static ?string $model = ReadingLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Literacy';
    protected static ?string $label = 'Reading Log';

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        // Jika user adalah Guru
        if ($user->hasRole('guru') && $user->teacher) {
            // Dapatkan ID tahun ajaran aktif dari service
            $activeYearId = (new CurrentAcademicYearService())->id();

            // Dapatkan ID rombel (kelas) yang diampu guru saat ini
            $classSection = $user->teacher->homeroomClasses()
                ->where('academic_year_id', $activeYearId)
                ->first();

            if ($classSection) {
                // Dapatkan semua ID siswa di kelas tersebut
                $studentIds = $classSection->students()->pluck('students.id');
                // Kembalikan query yang hanya berisi data siswa dari kelasnya
                return parent::getEloquentQuery()->whereIn('student_id', $studentIds);
            }
            // Jika guru tidak punya kelas, jangan tampilkan apa-apa
            return parent::getEloquentQuery()->whereNull('id');
        }

        // Jika Admin atau PJ, tampilkan semua data (sudah terfilter oleh Global Scope)
        return parent::getEloquentQuery();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->relationship('student', 'full_name')
                    ->searchable()
                    ->required()
                    ->label('Student'),

                Forms\Components\TextInput::make('book_title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('status')
                    ->options([
                        'Sedang Dibaca' => 'Sedang Dibaca',
                        'Selesai' => 'Selesai',
                    ])
                    ->required()
                    ->default('Sedang Dibaca'),

                Forms\Components\TextInput::make('last_page_read')
                    ->numeric()
                    ->label('Halaman Terakhir Dibaca'),

                Forms\Components\TextInput::make('total_pages')
                    ->numeric()
                    ->label('Total Halaman Buku'),

                Forms\Components\DatePicker::make('date_reported')
                    ->label('Date Reported')
                    ->required()
                    ->default(now())
                    ->native(false),

                Forms\Components\Hidden::make('academic_year_id')
                    ->default((new CurrentAcademicYearService())->id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.full_name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('book_title')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('status')
                    ->colors([
                        'primary' => 'Sedang Dibaca',
                        'success' => 'Selesai',
                    ]),
                
                // Tables\Columns\ProgressBar::make('progress_percentage')
                //     ->label('Progress')
                //     ->color('primary'),
                
                Tables\Columns\TextColumn::make('date_reported')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('student_id')
                    ->relationship('student', 'full_name')
                    ->label('Filter by Student'),

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Sedang Dibaca' => 'Sedang Dibaca',
                        'Selesai' => 'Selesai',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('review')
                    ->label('Review')
                    ->icon('heroicon-s-chat-bubble-left-right')
                    ->color('success')
                    ->visible(fn (ReadingLog $record): bool => $record->status === 'Selesai')
                    ->action(function (ReadingLog $record) {
                        // Cari review yang ada, atau BUAT JIKA TIDAK ADA
                        $review = $record->bookReview()->firstOrCreate(
                            // Kunci untuk mencari:
                            [
                                'reading_log_id' => $record->id,
                            ],
                            // Data untuk diisi jika record baru dibuat:
                            [
                                'student_id' => $record->student_id,
                                'academic_year_id' => $record->academic_year_id,
                            ]
                        );

                        // Redirect ke halaman edit dari review yang sudah pasti ada
                        redirect()->to(BookReviewResource::getUrl('edit', ['record' => $review]));
                    }),
                    // ->url(fn (ReadingLog $record): string => BookReviewResource::getUrl('edit', ['record' => $record->bookReview?->id ?? 0]) . "?reading_log_id=" . $record->id)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReadingLogs::route('/'),
            'create' => Pages\CreateReadingLog::route('/create'),
            'edit' => Pages\EditReadingLog::route('/{record}/edit'),
        ];
    }
}
