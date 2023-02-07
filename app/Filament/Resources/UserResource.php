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
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
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
                    ->placeholder('Ecrivez le pseudo de l\'utilisateur')
                    ->label('Pseudo'),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->placeholder('Ecivez l\'email de l\'utilisateur')
                    ->label('Email'),
                Forms\Components\TextInput::make('password')
                    ->required()
                    ->placeholder('Rentrez le mot de passe de l\'utilisateur')
                    ->type('password')
                    ->label('Mot de passe'),
                Forms\Components\TextInput::make('experience')
                    ->required()
                    ->default(0)
                    ->placeholder('Rentrez l\'expérience de l\'utilisateur')
                    ->label('Expérience'),
                Forms\Components\TextInput::make('picture')
                    ->required()
                    ->default('https://via.placeholder.com/640x480.png/002244?text=et')
                    ->placeholder('Rentrez l\'URL de l\'avatar de l\'utilisateur')
                    ->label('Avatar'),
                Forms\Components\TextInput::make('banner')
                    ->required()
                    ->default('https://via.placeholder.com/640x480.png/002244?text=et')
                    ->placeholder('Rentrez l\'URL de la bannière de l\'utilisateur')
                    ->label('Bannière'),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->default('Nouveau joueur !')
                    ->placeholder('Ecrivez une description de l\'utilisateur')
                    ->label('Description'),
                Forms\Components\Select::make('role_id')
                    ->options(Role::all()->pluck('name', 'id'))
                    ->required()
                    ->default(2)
                    ->label('Rôle'),
                Forms\Components\Select::make('rank_id')
                    ->options(Rank::all()->pluck('name', 'id'))
                    ->required()
                    ->default(1)
                    ->label('Rang'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->searchable()
                    ->label('ID'),
                TextColumn::make('pseudo')
                    ->sortable()
                    ->searchable()
                    ->label('Pseudo'),
                TextColumn::make('role.name')->label('Role'),
                TextColumn::make('rank.name')->label('Rang'),
                TextColumn::make('experience')->label('Expérience'),
                TextColumn::make('email'),
                TextColumn::make('phone')->label('Téléphone'),
                TextColumn::make('description')->label('Description'),
                ImageColumn::make('picture')->label('Photo'),
                ImageColumn::make('banner')->label('Bannière'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
