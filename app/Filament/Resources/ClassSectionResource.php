<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassSectionResource\Pages;
use App\Filament\Resources\ClassSectionResource\RelationManagers;
use App\Models\AcademicYear;
use App\Models\ClassSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClassSectionResource extends Resource
{
    protected static ?string $model = ClassSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    
    public static function getNavigationGroup(): string
    {
        return __('models/class_section.navigation_group');
    }

    public static function getModelLabel(): string
    {
        return __('models/class_section.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('models/class_section.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('models/class_section.sections.class_section_information'))
                    ->schema([
                        Forms\Components\Select::make('grade_level_id')
                            ->label(__('models/class_section.attributes.grade_level'))
                            ->relationship('gradeLevel', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('section_name')
                            ->label(__('models/class_section.attributes.section_name'))
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('academic_year_id')
                            ->label(__('models/class_section.attributes.academic_year'))
                            ->relationship('academicYear', 'academic_year_name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->default(fn () => AcademicYear::where('status', 'Active')->first()?->id),

                        Forms\Components\Select::make('teacher_id')
                            ->label(__('models/class_section.attributes.homeroom_teacher'))
                            ->relationship('homeroomTeacher', 'full_name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('gradeLevel.name')
                    ->label(__('models/class_section.attributes.grade_level'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('section_name')
                    ->label(__('models/class_section.attributes.section_name'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('academicYear.academic_year_name')
                    ->label(__('models/class_section.attributes.academic_year'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('homeroomTeacher.full_name')
                    ->label(__('models/class_section.attributes.homeroom_teacher'))
                    ->sortable()
                    ->searchable()
                    ->placeholder(__('models/class_section.attributes.not_assigned')),

                Tables\Columns\TextColumn::make('students_count')
                    ->counts('students')
                    ->label(__('models/class_section.attributes.total_students')),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('academic_year_id')
                    ->relationship('academicYear', 'academic_year_name')
                    ->label(__('models/class_section.attributes.filter_by_academic_year'))
                    ->default(fn () => AcademicYear::where('status', 'Active')->first()?->id),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            RelationManagers\StudentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClassSections::route('/'),
            'create' => Pages\CreateClassSection::route('/create'),
            'edit' => Pages\EditClassSection::route('/{record}/edit'),
        ];
    }
}
