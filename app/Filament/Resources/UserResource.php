<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\Text;
use Filament\Resources\Form;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $recordTitleAttribute = 'pseudo';
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('pseudo')
                    ->required()
                    ->autofocus()
                    ->placeholder('Pseudo'),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->placeholder('Email'),
                Forms\Components\TextInput::make('password')
                    ->required()
                    ->placeholder('Mot de passe')
                    ->type('password'),
                Forms\Components\TextInput::make('experience')
                    ->placeholder('Expérience'),
                Forms\Components\TextInput::make('experience_cap')
                    ->placeholder('Expérience max'),
                Forms\Components\TextInput::make('rank_id')
                    ->placeholder('Rang'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pseudo'),
                Tables\Columns\TextColumn::make('email'),
            ])
            ->filters([
                Tables\Filters\Filter::make('verified')
                ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }    
}
