<?php

namespace App\Filament\Resources\BadgeUserResource\Pages;

use App\Filament\Resources\BadgeUserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBadgeUsers extends ListRecords
{
    protected static string $resource = BadgeUserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
