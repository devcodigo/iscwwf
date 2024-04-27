<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers;
use App\Filament\Resources\ItemResource\RelationManagers\TransactionsRelationManager;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?string $navigationGroup = 'Majetek';
    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Exemplář';
    protected static ?string $pluralModelLabel = 'Exempláře';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('inventory')
                    ->required()
                    ->label('Inv. č.')
                    ->maxLength(255)
                    ->label('Inv. číslo'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Název')
                    ->maxLength(255)
                    ->label('Název'),
                Forms\Components\TextInput::make('description')
                    ->maxLength(255)
                    ->label('Popis')
                    ->default(null),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->label('Cena')
                    ->numeric()
                    ->default(0)
                    ->prefix('Kč'),
                Forms\Components\TextInput::make('purchased')
                    ->maxLength(255)
                    ->label('Pořízeno')
                    ->default(null),
                Forms\Components\Select::make('condition')
                    ->options([
                        'Nové' => 'Nové',
                        'Dobrý' => 'Dobrý',
                        'Zhoršený' => 'Zhoršený',
                        'Zastaralé' => 'Zastaralé',
                        'Zničeno' => 'Zničeno',
                        'Ztraceno' => 'Ztraceno',
                        'Vyřazeno' => 'Vyřazeno'])
                    ->required()
                    ->label('Stav'),
                Forms\Components\Select::make('stock_id')
                    ->required()
                    ->label('Položka')
                    ->relationship('stock','name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('inventory')
                    ->searchable()
                    ->label('Inv. č.'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Název'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Pops'),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->label('Cena'),
                Tables\Columns\TextColumn::make('purchased')
                    ->sortable()
                    ->label('Pořízeno'),
                Tables\Columns\TextColumn::make('condition')
                    ->label('Stav'),
                Tables\Columns\TextColumn::make('stock.name')
                    ->label('Položka'),
                Tables\Columns\TextColumn::make('stock.category.name')
                    ->label('Kategorie'),
                Tables\Columns\TextColumn::make('lastTransaction.storage.name')
                ->label('Umístění')

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('stock_id')                
                ->relationship('stock','name')
                ->label('Položka'),
                Tables\Filters\SelectFilter::make('stock.category_id')
                ->relationship('stock.category','name')
                ->label('Kategorie'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TransactionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
