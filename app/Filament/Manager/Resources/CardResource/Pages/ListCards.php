<?php

namespace App\Filament\Manager\Resources\CardResource\Pages;

use App\Filament\Manager\Resources\CardResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCards extends ListRecords
{
    protected static string $resource = CardResource::class;

    protected function getHeaderActions(): array
    {
        return [
          
        ];
    }
}
