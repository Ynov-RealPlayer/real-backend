<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentaryResource\Pages;
use App\Filament\Resources\CommentaryResource\RelationManagers;
use App\Models\Commentary;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommentaryResource extends Resource
{
    protected static ?string $model = Commentary::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

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
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('content'),
                Tables\Columns\TextColumn::make('user.pseudo'),
                Tables\Columns\TextColumn::make('media.name'),
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
            'index' => Pages\ListCommentaries::route('/'),
            'create' => Pages\CreateCommentary::route('/create'),
            'edit' => Pages\EditCommentary::route('/{record}/edit'),
        ];
    }
}
