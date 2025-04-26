<?php

namespace App\Filament\Resources\PupukResource\Pages;

use App\Filament\Resources\PupukResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPupuk extends ListRecords
{
    protected static string $resource = PupukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}