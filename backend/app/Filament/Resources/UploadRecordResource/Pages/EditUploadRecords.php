<?php

namespace App\Filament\Resources\UploadRecordResource\Pages;

use App\Filament\Resources\UploadRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUploadRecords extends EditRecord
{
    protected static string $resource = UploadRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
