<?php

namespace App\Filament\Resources\ReadingLogResource\Pages;

use App\Filament\Resources\ReadingLogResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReadingLog extends CreateRecord
{
    protected static string $resource = ReadingLogResource::class;
}
