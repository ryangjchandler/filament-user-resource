<?php

namespace RyanChandler\FilamentUserResource;

use Filament\PluginServiceProvider;
use RyanChandler\FilamentUserResource\Resources\UserResource;

class FilamentUserResourceServiceProvider extends PluginServiceProvider
{
    public static string $name = 'filament-user-resource';

    protected array $resources = [
        UserResource::class,
    ];
}
