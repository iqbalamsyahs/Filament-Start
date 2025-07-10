<?php

namespace App\Filament\Resources\ReadingLogResource\Pages;

use App\Filament\Resources\ReadingLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReadingLog extends EditRecord
{
    protected static string $resource = ReadingLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
