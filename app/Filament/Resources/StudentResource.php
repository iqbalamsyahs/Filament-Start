<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    
    public static function getNavigationGroup(): string
    {
        return __('models/student.navigation_group');
    }

    public static function getModelLabel(): string
    {
        return __('models/student.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('models/student.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('models/student.sections.personal_information'))
                    ->schema([
                        Forms\Components\FileUpload::make('photo')
                            ->label(__('models/student.attributes.photo'))
                            ->image()
                            ->avatar()
                            ->imageEditor()
                            ->circleCropper()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('full_name')
                            ->label(__('attributes.full_name'))
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('nisn')
                            ->label(__('models/student.attributes.nisn'))
                            ->unique(ignoreRecord: true)
                            ->nullable(),

                        Forms\Components\TextInput::make('nis')
                            ->label(__('models/student.attributes.nis'))
                            ->unique(ignoreRecord: true)
                            ->nullable(),

                        Forms\Components\Select::make('gender')
                            ->label(__('models/student.attributes.gender'))
                            ->options([
                                'L' => __('models/student.values.gender.L'),
                                'P' => __('models/student.values.gender.P'),
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('place_of_birth')
                            ->label(__('models/student.attributes.place_of_birth'))
                            ->nullable(),

                        Forms\Components\DatePicker::make('date_of_birth')
                            ->label(__('models/student.attributes.date_of_birth'))
                            ->required()
                            ->native(false),
                    ])->columns(2),

                Forms\Components\Section::make(__('models/student.sections.academic_information'))
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label(__('attributes.status'))
                            ->options([
                                'Aktif' => __('models/student.values.status.aktif'),
                                'Pindah' => __('models/student.values.status.pindah'),
                                'Lulus' => __('models/student.values.status.lulus'),
                            ])
                            ->required()
                            ->default('Aktif'),

                        Forms\Components\Textarea::make('address')
                            ->label(__('attributes.address'))
                            ->nullable()
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo_url')
                    ->label(__('models/student.attributes.photo'))
                    ->circular(),

                Tables\Columns\TextColumn::make('full_name')
                    ->label(__('attributes.full_name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nisn')
                    ->label(__('models/student.attributes.nisn'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('gender')
                    ->label(__('models/student.attributes.gender'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label(__('attributes.status'))
                    ->colors([
                        'success' => 'Aktif',
                        'warning' => 'Pindah',
                        'danger' => 'Lulus',
                    ])
                    ->searchable(),
            ])
            ->filters([
                //
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
            RelationManagers\ClassSectionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}