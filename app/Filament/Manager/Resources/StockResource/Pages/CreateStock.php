<?php

namespace App\Filament\Manager\Resources\StockResource\Pages;

use App\Filament\Manager\Resources\StockResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStock extends CreateRecord
{
    protected static string $resource = StockResource::class;
}
