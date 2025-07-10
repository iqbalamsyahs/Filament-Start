<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use App\Filament\Resources\TeacherResource\RelationManagers;
use App\Models\Teacher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    
    public static function getNavigationGroup(): string
    {
        return __('models/teacher.navigation_group');
    }

    public static function getModelLabel(): string
    {
        return __('models/teacher.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('models/teacher.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Profil Guru')
                    ->schema([
                        Forms\Components\TextInput::make('nip')
                            ->label(__('models/teacher.attributes.nip'))
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->nullable(),

                        Forms\Components\TextInput::make('full_name')
                            ->label(__('attributes.full_name'))
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('phone_number')
                            ->label(__('attributes.phone_number'))
                            ->maxLength(255)
                            ->nullable(),
                    ])->columns(2),

                Forms\Components\Section::make('Informasi Akun Login')
                    ->schema([
                        Forms\Components\TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create') // Wajib diisi saat membuat
                            ->dehydrated(fn ($state) => filled($state)) // Hanya simpan jika diisi
                            ->helperText('Kosongkan jika tidak ingin mengubah password saat mengedit.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nip')
                    ->label(__('models/teacher.attributes.nip'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('full_name')
                    ->label(__('attributes.full_name'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone_number')
                    ->label(__('attributes.phone_number'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('models/teacher.attributes.user'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('attributes.created_at'))
                    ->dateTime('d M Y')
                    ->sortable(),
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
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }
}
