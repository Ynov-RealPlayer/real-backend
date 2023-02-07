<?php

namespace App\Filament\Resources\CommentaryResource\Pages;

use App\Filament\Resources\CommentaryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCommentary extends CreateRecord
{
    protected static string $resource = CommentaryResource::class;
}
