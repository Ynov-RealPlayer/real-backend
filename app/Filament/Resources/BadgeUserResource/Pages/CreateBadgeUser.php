<?php

namespace App\Filament\Resources\BadgeUserResource\Pages;

use App\Filament\Resources\BadgeUserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBadgeUser extends CreateRecord
{
    protected static string $resource = BadgeUserResource::class;
}
