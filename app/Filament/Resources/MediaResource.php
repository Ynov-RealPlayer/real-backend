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
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Livewire\TemporaryUploadedFile;
use Filament\Tables\Columns\ImageColumn;
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
                    ->placeholder('Ecrivez le nom du média')
                    ->label('Nom'),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->default('Nouveau Media !')
                    ->placeholder('Ecrivez la description du média')
                    ->label('Description'),
                Forms\Components\FileUpload::make('url')
                    ->disk('s3')
                    ->required()
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        $extension = $file->getClientOriginalExtension();
                        $path = time() . $extension;
                        $file = Image::make($file)->resize(1080, 1920)->encode($extension)->save();
                        Storage::disk('s3')->put($path, $file);
                        return $path;
                    })
                    ->visibility('public'),
                Forms\Components\Select::make('category_id')
                    ->required()
                    ->placeholder('Sélectionnez la catégorie')
                    ->options(function () {
                        return Category::all()->pluck('name', 'id');
                    })
                    ->label('Catégorie'),
                Forms\Components\Select::make('user_id')
                    ->required()
                    ->placeholder('Sélectionnez l\'utilisateur')
                    ->options(function () {
                        return User::all()->pluck('pseudo', 'id');
                    })
                    ->label('Utilisateur'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable()
                    ->label('ID'),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Nom'),
                ImageColumn::make('url')
                    ->label('Ressource'),
                Tables\Columns\TextColumn::make('user.pseudo')
                    ->sortable()
                    ->searchable()
                    ->label('Utilisateur'),
                Tables\Columns\TextColumn::make('nb_likes')
                    ->label('Nombre de like'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description'),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Catégorie'),
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
            'index' => Pages\ListMedia::route('/'),
            'create' => Pages\CreateMedia::route('/create'),
            'edit' => Pages\EditMedia::route('/{record}/edit'),
        ];
    }
}
