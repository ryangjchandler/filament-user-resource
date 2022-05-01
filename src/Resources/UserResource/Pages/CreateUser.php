<?php

namespace RyanChandler\FilamentUserResource\Resources\UserResource\Pages;

use RyanChandler\FilamentUserResource\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
