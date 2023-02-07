<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Media;
use App\Models\Commentary;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CommentaryResource\Pages;
use App\Filament\Resources\CommentaryResource\RelationManagers;

class CommentaryResource extends Resource
{
    protected static ?string $model = Commentary::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('content')
                    ->required()
                    ->autofocus()
                    ->placeholder('Contenu'),
                Forms\Components\Select::make('user_id')
                    ->options(User::all()->pluck('pseudo', 'id'))
                    ->required()
                    ->placeholder('Utilisateur'),
                Forms\Components\Select::make('media_id')
                    ->options(Media::all()->pluck('name', 'id'))
                    ->required()
                    ->placeholder('Media'),
                Forms\Components\TextInput::make('nb_like')
                    ->required()
                    ->default(0)
                    ->placeholder('Nombre de likes'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('content'),
                Tables\Columns\TextColumn::make('nb_like')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.pseudo')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('media.name')
                    ->sortable()
                    ->searchable(),
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
            'index' => Pages\ListCommentaries::route('/'),
            'create' => Pages\CreateCommentary::route('/create'),
            'edit' => Pages\EditCommentary::route('/{record}/edit'),
        ];
    }
}
