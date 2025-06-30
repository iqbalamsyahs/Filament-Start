<?php

namespace App\Filament\Resources\ClassSectionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('full_name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')
            ->columns([
                Tables\Columns\TextColumn::make('nisn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->form(fn (AttachAction $action): array => [
                        // Helper untuk mendapatkan select field standar, lalu kita modifikasi
                        $action->getRecordSelect()
                            ->searchable() // Terapkan searchable di sini, pada select field
                            ->preload(false) // Sebaiknya false jika searchable dengan banyak data
                            ->searchDebounce(500) // Jeda 500ms setelah user mengetik sebelum mencari
                            ->getSearchResultsUsing(fn (string $search) => \App\Models\Student::where('full_name', 'like', "%{$search}%")->orWhere('nisn', 'like', "%{$search}%")->limit(50)->pluck('full_name', 'id')), // Logika pencarian custom
                    ]),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
