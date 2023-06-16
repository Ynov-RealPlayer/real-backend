<?php

namespace App\Filament\Resources\MediaResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Filament\Resources\MediaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMedia extends CreateRecord
{
    protected static string $resource = MediaResource::class;

}
