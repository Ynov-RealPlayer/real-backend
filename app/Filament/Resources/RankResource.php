<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Rank;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RankResource\Pages;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Forms\Components\ColorPicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RankResource\RelationManagers;

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
                    ->placeholder('Ecrivez le nom du rang')
                    ->label('Nom'),
                Forms\Components\TextInput::make('experience_cap')
                    ->required()
                    ->default(0)
                    ->placeholder('Ecrivez l\'expérience nécessaire pour atteindre ce rang')
                    ->label('Expérience'),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->default('Nouveau Rang !')
                    ->placeholder('Ecrivez la description du rang')
                    ->label('Description'),
                ColorPicker::make('color')
                    ->required()
                    ->default('#002244')
                    ->placeholder('Sélectionnez la couleur du rang')
                    ->label('Couleur'),
                Forms\Components\TextInput::make('icon')
                    ->required()
                    ->default('https://via.placeholder.com/640x480.png/002244?text=et')
                    ->placeholder('Ecrivez l\'URL de l\'icône du rang')
                    ->label('Icône'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Nom'),
                Tables\Columns\TextColumn::make('experience_cap'),
                Tables\Columns\TextColumn::make('description'),
                ColorColumn::make('color')
                    ->copyable()
                    ->copyMessage('🧙‍♂️ Code couleur copié !')
                    ->copyMessageDuration(1500)
                    ->label('Couleur'),
                Tables\Columns\TextColumn::make('icon')
                    ->default('👀')
                    ->label('Icône'),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->searchable()
                    ->label('Créé le'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->sortable()
                    ->searchable()
                    ->label('Modifié le'),
            ])
            ->filters([
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
