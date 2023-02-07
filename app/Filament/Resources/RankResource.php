<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RankResource\Pages;
use App\Filament\Resources\RankResource\RelationManagers;
use App\Models\Rank;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RankResource extends Resource
{
    protected static ?string $model = Rank::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->autofocus()
                    ->placeholder('Nom'),
                Forms\Components\TextInput::make('experience_cap')
                    ->required()
                    ->default(0)
                    ->placeholder('Expérience'),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->default('Nouveau Rang !')
                    ->placeholder('Description'),
                Forms\Components\TextInput::make('color')
                    ->required()
                    ->default('#000000')
                    ->placeholder('Couleur'),
                Forms\Components\TextInput::make('icon')
                    ->required()
                    ->default('https://via.placeholder.com/640x480.png/002244?text=et')
                    ->placeholder('Icône'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('experience_cap'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('color'),
                Tables\Columns\TextColumn::make('icon'),
            ])
            ->filters([
                // TODO: Add filters
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListRanks::route('/'),
            'create' => Pages\CreateRank::route('/create'),
            'edit' => Pages\EditRank::route('/{record}/edit'),
        ];
    }
}
