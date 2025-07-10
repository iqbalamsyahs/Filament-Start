<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookReviewResource\Pages;
use App\Filament\Resources\BookReviewResource\RelationManagers;
use App\Models\BookReview;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookReviewResource extends Resource
{
    protected static ?string $model = BookReview::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Book & Student Information')
                    ->schema([
                        // Mengambil judul buku dari relasi readingLog
                        Forms\Components\TextInput::make('book_title')
                            ->label('Book Title')
                            ->disabled(),
                        
                        // Mengambil nama siswa dari relasi student
                        Forms\Components\TextInput::make('student_full_name')
                            ->label('Student')
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Teacher\'s Assessment')
                    ->schema([
                        Forms\Components\Textarea::make('review_content')
                            ->label('Student\'s Review Content (if any)')
                            ->rows(5)
                            ->helperText('Salin-tempel atau tulis ringkasan review dari siswa di sini.'),
                        
                        Forms\Components\TextInput::make('review_grade')
                            ->label('Grade (1-100)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100),
                        
                        Forms\Components\Textarea::make('teacher_comments')
                            ->label('Teacher\'s Comments & Feedback')
                            ->rows(5)
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('readingLog.book_title')->searchable(),
                Tables\Columns\TextColumn::make('student.full_name')->searchable(),
                Tables\Columns\TextColumn::make('review_grade')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListBookReviews::route('/'),
            // 'create' => Pages\CreateBookReview::route('/create'),
            'edit' => Pages\EditBookReview::route('/{record}/edit'),
        ];
    }
}
