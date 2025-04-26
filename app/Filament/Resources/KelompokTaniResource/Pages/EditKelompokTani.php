<?php

namespace App\Filament\Resources\KelompokTaniResource\Pages;

use App\Filament\Resources\KelompokTaniResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKelompokTani extends EditRecord
{
    protected static string $resource = KelompokTaniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
