<?php

namespace App\Filament\Manager\Resources;

use App\Filament\Manager\Resources\StockResource\Pages;
use App\Filament\Manager\Resources\StockResource\RelationManagers;
use App\Filament\Manager\Resources\StockResource\RelationManagers\ItemsRelationManager;
use App\Models\Stock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StockResource extends Resource
{
    protected static ?string $model = Stock::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationGroup = 'Majetek';
    
    protected static ?string $modelLabel = 'Položka';
    protected static ?string $pluralModelLabel = 'Položky';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->disabled()
                    ->maxLength(255),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->disabled(),
                Forms\Components\Toggle::make('active')
                ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Název'),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategorie')
                    ->sortable(),
                Tables\Columns\IconColumn::make('active')
                    ->label('Aktivní')
                    ->boolean(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category','name'),
                Tables\Filters\Filter::make('active')->toggle()->default(true),
            ])
            ->actions([
       
            ])
            ->bulkActions([
 
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStocks::route('/'),
        //    'create' => Pages\CreateStock::route('/create'),
            'edit' => Pages\EditStock::route('/{record}/edit'),
        ];
    }
}
