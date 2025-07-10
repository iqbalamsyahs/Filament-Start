<?php

namespace App\Filament\Resources\ReadingLogResource\Pages;

use App\Filament\Resources\ReadingLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReadingLogs extends ListRecords
{
    protected static string $resource = ReadingLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
