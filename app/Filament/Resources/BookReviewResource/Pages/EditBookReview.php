<?php

namespace App\Filament\Resources\BookReviewResource\Pages;

use App\Filament\Resources\BookReviewResource;
use App\Filament\Resources\ReadingLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditBookReview extends EditRecord
{
    protected static string $resource = BookReviewResource::class;

    public function mount(int | string $record): void
    {
        parent::mount($record);
        $this->record->load(['readingLog', 'student']);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),

            Actions\Action::make('back')
                ->label('Kembali ke Log Bacaan')
                ->color('gray')
                ->url(ReadingLogResource::getUrl('index')),
        ];
    }

    protected function afterSave(): void
    {
        // Ambil record ReadingLog yang terhubung dengan review ini
        $readingLog = $this->record->readingLog;

        // Jika ada, update statusnya menjadi 'Sudah Dinilai'
        if ($readingLog) {
            $readingLog->update(['review_status' => 'Sudah Dinilai']);
        }
    }
}
