<?php

namespace App\Filament\Resources\StockResource\RelationManagers;

use App\Filament\Resources\ItemResource;
use App\Models\Item;
use App\Models\Storage;
use App\Models\Transaction;
use Illuminate\Support\Collection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\ReplicateAction;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Actions\ReplicateAction as ActionsReplicateAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use phpDocumentor\Reflection\Types\Void_;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $modelLabel = 'Exempláře';
    protected static ?string $pluralModelLabel = 'Exempláře';
    

    public function form(Form $form): Form
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
                    ->maxLength(50),
                Forms\Components\TextInput::make('description')
                    ->maxLength(255)
                    ->label('Popis'),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->label('Cena')
                    ->numeric()
                    ->default(0)
                    ->prefix('Kč'),
                Forms\Components\TextInput::make('purchased')
                    ->numeric()
                    ->label('Pořízeno'),
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

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('inventory')
                    ->label('Inv.č.'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Název'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Popis'),
                Tables\Columns\TextColumn::make('condition')
                    ->label('Stav'),
                Tables\Columns\TextColumn::make('purchased')
                    ->label('Pořízeno'),
                Tables\Columns\TextColumn::make('price')->money('czk')
                    ->label('Cena'),
                Tables\Columns\TextColumn::make('lastTransaction.storage.name')
                    ->label('Umístění'),

                
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->label(''),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('Manage')
                    ->label('MAN')
                    ->url(fn ($record) => ItemResource::getUrl('edit',[$record->id]))
                    ->color('green')
                    ->icon('heroicon-o-arrow-right-circle'),
                ActionsReplicateAction::make(),
                
                Tables\Actions\Action::make('Move')
                    ->label('Přesunout')
                    ->form([
                        Forms\Components\DatePicker::make('date')
                            ->required()
                            ->label('Datum')
                            ->default(now()),
                        
                        Forms\Components\Select::make('storage_type')
                            ->live()
                            ->dehydrated(false)
                            ->options(Storage::orderby('type')->pluck('type','type')->toArray())
                            ->label('Typ umístění'),    
                        Forms\Components\Select::make('storage_id')
                            ->required()
                            ->options( function (Forms\Get $get): Collection {
                                return $get('storage_type') ? Storage::where('type',$get('storage_type'))->orderby('name')->pluck('name','id') : Storage::orderby('name')->pluck('name','id');
                            } )
                                
                                
                               // Storage::orderby('name')->pluck('name','id')->toArray())
                            ->label('Umístění'),    
                    ])
                    ->action( function(Item $item,array $data):void {
                        $transaction = new Transaction;
                        $transaction->date = $data['date'];
                        $transaction->user_id = auth()->id();
                        $transaction->item_id = $item->id;
                        $transaction->storage_id=$data['storage_id'];
                        $transaction->save();
                        }
    
                    )
                    ->icon('heroicon-o-arrow-right-start-on-rectangle'),
                    
                


            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
