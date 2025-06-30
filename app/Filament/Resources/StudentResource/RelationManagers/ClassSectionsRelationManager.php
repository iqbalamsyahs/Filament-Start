<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClassSectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'classSections';
    
    protected static ?string $title = 'Class Enrollment History';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // ...
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('academicYear.academic_year_name')
                    ->label('Academic Year'),
                // Menggabungkan Grade Level dan Section Name
                Tables\Columns\TextColumn::make('full_name') // Langsung panggil 'full_name'
                    ->label('Class Name')
                    ->sortable(['grade_level_id', 'section_name']) // Konfigurasi sorting jika diperlukan
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        // Logika pencarian custom untuk full_name
                        return $query
                            ->whereHas('gradeLevel', function ($q) use ($search) {
                                $q->where('name', 'like', "%{$search}%");
                            })
                            ->orWhere('section_name', 'like', "%{$search}%");
                    }),
                Tables\Columns\TextColumn::make('homeroomTeacher.full_name')
                    ->label('Homeroom Teacher'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tidak ada header action karena pendaftaran dilakukan dari ClassSectionResource
            ])
            ->actions([
                // Tidak ada action karena ini hanya riwayat (read-only)
            ])
            ->bulkActions([
                // Tidak ada bulk action
            ]);
    }
}
