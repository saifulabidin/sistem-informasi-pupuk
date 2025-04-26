<?php

namespace App\Filament\Resources\AlokasiPupukResource\Pages;

use App\Filament\Resources\AlokasiPupukResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAlokasiPupuks extends ListRecords
{
    protected static string $resource = AlokasiPupukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
