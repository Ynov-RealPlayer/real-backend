<?php

namespace App\Filament\Resources\CommentaryResource\Pages;

use App\Filament\Resources\CommentaryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCommentaries extends ListRecords
{
    protected static string $resource = CommentaryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
