<?php

namespace RyanChandler\FilamentUserResource\Resources\UserResource\Pages;

use RyanChandler\FilamentUserResource\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;
}
