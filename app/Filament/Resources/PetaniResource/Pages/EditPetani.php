<?php

namespace App\Filament\Resources\PetaniResource\Pages;

use App\Filament\Resources\PetaniResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPetani extends EditRecord
{
    protected static string $resource = PetaniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
