<?php

namespace App\Filament\Resources\AlokasiPupukResource\Pages;

use App\Filament\Resources\AlokasiPupukResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAlokasiPupuk extends EditRecord
{
    protected static string $resource = AlokasiPupukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
