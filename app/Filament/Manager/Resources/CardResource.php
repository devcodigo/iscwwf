<?php

namespace App\Filament\Manager\Resources;

use App\Filament\Manager\Resources\CardResource\Pages;
use App\Filament\Manager\Resources\CardResource\RelationManagers;
use App\Models\Card;
use App\Models\Storage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CardResource extends Resource
{
    protected static ?string $model = Storage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Majetek';
    
    protected static ?string $modelLabel = 'Karta výstroje';
    protected static ?string $pluralModelLabel = 'Karty výstroje';
    

    public static function getEloquentQuery(): Builder
{
    return Storage::where('type','REPRE')->orderby('name');
}
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Název'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Detail'),
                Tables\Actions\Action::make('Card')
                    ->label('Karta')
                    ->url(fn($record) => route('stockCard',['id'=> $record->id]))
                    ->icon('heroicon-o-document-text'),
            
            ])
            ->bulkActions([
                
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCards::route('/'),
            'create' => Pages\CreateCard::route('/create'),
            'edit' => Pages\EditCard::route('/{record}/edit'),
        ];
    }
}
