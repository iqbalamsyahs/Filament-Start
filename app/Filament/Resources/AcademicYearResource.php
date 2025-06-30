<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcademicYearResource\Pages;
use App\Filament\Resources\AcademicYearResource\RelationManagers;
use App\Models\AcademicYear;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Contracts\Support\Htmlable;

class AcademicYearResource extends Resource
{
    protected static ?string $model = AcademicYear::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-date-range';
    
    public static function getNavigationGroup(): string
    {
        return __('models/student.navigation_group');
    }

    public static function getModelLabel(): string
    {
        return __('models/academic_year.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('models/academic_year.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('academic_year_name')
                    ->label(__('models/academic_year.attributes.academic_year_name'))
                    ->required()
                    ->maxLength(255),

                Forms\Components\DatePicker::make('start_date')
                    ->label(__('models/academic_year.attributes.start_date'))
                    ->required(),

                Forms\Components\DatePicker::make('end_date')
                    ->label(__('attributes.end_date'))
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label(__('attributes.status'))
                    ->options([
                        'upcoming' => __('models/academic_year.values.status.upcoming'),
                        'active' => __('models/academic_year.values.status.active'),
                        'completed' => __('models/academic_year.values.status.completed'),
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('academic_year_name')
                    ->label(__('models/academic_year.label'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label(__('attributes.start_date'))
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->label(__('attributes.end_date'))
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label(__('attributes.status'))
                    ->sortable()
                    ->colors([
                        'success' => __('models/academic_year.values.status.active'),
                        'danger' => __('models/academic_year.values.status.upcoming'),
                    ]),
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
            'index' => Pages\ListAcademicYears::route('/'),
            'create' => Pages\CreateAcademicYear::route('/create'),
            'edit' => Pages\EditAcademicYear::route('/{record}/edit'),
        ];
    }
}
