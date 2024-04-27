<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';
    protected static ?string $navigationGroup = 'Majetek';
    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Transakce';
    protected static ?string $pluralModelLabel = 'Transakce';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->required()
                    ->label('Datum'),
                Forms\Components\Select::make('user_id')
                    ->required()
                    ->relationship('user','name')
                    ->label('Uživatel'),
                Forms\Components\Select::make('item_id')
                    ->required()
                    ->relationship('item','name')
                    ->label('Exemplář'),
                Forms\Components\Select::make('storage_id')
                    ->required()
                    ->relationship('storage','name')
                    ->label('Umístění'),    
                Forms\Components\TextInput::make('comment'),
                
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('item.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('storage.name')
                    ->numeric()
                    ->sortable(),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTransactions::route('/'),
        ];
    }
}
