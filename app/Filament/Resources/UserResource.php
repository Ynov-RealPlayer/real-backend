<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Rank;
use App\Models\Role;
use App\Models\User;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\Text;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\SelectColumn;
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
                    ->required()
                    ->default(0)
                    ->placeholder('Expérience'),
                Forms\Components\TextInput::make('picture')
                    ->required()
                    ->default('https://via.placeholder.com/640x480.png/002244?text=et')
                    ->placeholder('Photo'),
                Forms\Components\TextInput::make('banner')
                    ->required()
                    ->default('https://via.placeholder.com/640x480.png/002244?text=et')
                    ->placeholder('Bannière'),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->default('Nouveau joueur !')
                    ->placeholder('Description'),
                Forms\Components\Select::make('role_id')
                    ->options(Role::all()->pluck('name', 'id'))
                    ->required()
                    ->default(1),
                Forms\Components\Select::make('rank_id')
                    ->options(Rank::all()->pluck('name', 'id'))
                    ->required()
                    ->default(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pseudo'),
                Tables\Columns\TextColumn::make('role.name')->label('Role'),
                Tables\Columns\TextColumn::make('rank.name')->label('Rang'),
                Tables\Columns\TextColumn::make('experience')->label('Expérience'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('phone')->label('Téléphone'),
                Tables\Columns\TextColumn::make('description')->label('Description'),
                Tables\Columns\TextColumn::make('picture')->label('Photo'),
                Tables\Columns\TextColumn::make('banner')->label('Bannière'),
            ])
            ->filters([
                Tables\Filters\Filter::make('verified')
                ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
