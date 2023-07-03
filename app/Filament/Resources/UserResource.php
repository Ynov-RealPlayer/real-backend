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
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Livewire\TemporaryUploadedFile;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $recordTitleAttribute = 'name';
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
                Forms\Components\TextInput::make('experience')
                    ->required()
                    ->default(0)
                    ->placeholder('Rentrez l\'expérience de l\'utilisateur')
                    ->label('Expérience'),
                Forms\Components\FileUpload::make('picture')
                    ->disk('s3')
                    ->required()
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        $extension = $file->getClientOriginalExtension();
                        $path = time() . $extension;
                        $file = Image::make($file)->resize(800, 800)->encode($extension)->save();
                        Storage::disk('s3')->put($path, $file);
                        return $path;
                    })
                    ->visibility('public')
                    ->label('Avatar'),
                Forms\Components\FileUpload::make('banner')
                    ->disk('s3')
                    ->required()
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        $extension = $file->getClientOriginalExtension();
                        $path = time() . $extension;
                        $file = Image::make($file)->resize(1280, 720)->encode($extension)->save();
                        Storage::disk('s3')->put($path, $file);
                        return $path;
                    })
                    ->visibility('public')
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
                ImageColumn::make('picture')
                    ->label('Photo'),
                ImageColumn::make('banner')
                    ->label('Bannière'),
                TextColumn::make('email')
                    ->label('Email'),
                TextColumn::make('phone')
                    ->label('Téléphone'),
                TextColumn::make('role.name')
                    ->sortable()
                    ->searchable()
                    ->label('Rôle'),
                TextColumn::make('rank.name')
                    ->sortable()
                    ->searchable()
                    ->label('Rang'),
                TextColumn::make('experience')
                    ->sortable()
                    ->searchable()
                    ->label('Expérience'),
                TextColumn::make('description')
                    ->label('Description'),
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
            RelationManagers\BadgesRelationManager::class,
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
