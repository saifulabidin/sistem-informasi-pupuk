<?php

namespace App\Filament\Resources\PembelianPupukResource\Pages;

use App\Filament\Resources\PembelianPupukResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPembelianPupuk extends ListRecords
{
    protected static string $resource = PembelianPupukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}