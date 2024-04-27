<?php

namespace App\Filament\Manager\Resources\StockResource\Pages;

use App\Filament\Manager\Resources\StockResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStock extends EditRecord
{
    protected static string $resource = StockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
