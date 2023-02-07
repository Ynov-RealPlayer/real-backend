<?php

namespace App\Filament\Resources\CommentaryResource\Pages;

use App\Filament\Resources\CommentaryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCommentary extends EditRecord
{
    protected static string $resource = CommentaryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
