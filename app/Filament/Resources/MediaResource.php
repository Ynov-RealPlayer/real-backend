<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Media;
use App\Models\Category;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\MediaResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MediaResource\RelationManagers;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->autofocus()
                    ->placeholder('Nom'),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->default('Nouveau Media !')
                    ->placeholder('Description'),
                Forms\Components\Select::make('media_type')
                    ->required()
                    ->placeholder('Type de média')
                    ->options([
                        'SCREEN' => 'Image',
                        'CLIP' => 'Vidéo',
                    ]),
                Forms\Components\TextInput::make('url')
                    ->required()
                    ->default('https://via.placeholder.com/640x480.png/002244?text=et')
                    ->placeholder('URL'),
                Forms\Components\TextInput::make('duration')
                    ->required()
                    ->default('0')
                    ->placeholder('Durée'),
                Forms\Components\TextInput::make('nb_like')
                    ->required()
                    ->default('0')
                    ->placeholder('Nombre de likes'),
                Forms\Components\Select::make('category_id')
                    ->required()
                    ->placeholder('Catégorie')
                    ->options(function () {
                        return Category::all()->pluck('name', 'id');
                    }),
                Forms\Components\Select::make('user_id')
                    ->required()
                    ->placeholder('Utilisateur')
                    ->options(function () {
                        return User::all()->pluck('pseudo', 'id');
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.pseudo')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nb_like'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('category.name'),
                Tables\Columns\TextColumn::make('media_type'),
                Tables\Columns\TextColumn::make('url'),
                Tables\Columns\TextColumn::make('duration'),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->sortable()
                    ->searchable(),
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
            'index' => Pages\ListMedia::route('/'),
            'create' => Pages\CreateMedia::route('/create'),
            'edit' => Pages\EditMedia::route('/{record}/edit'),
        ];
    }
}
