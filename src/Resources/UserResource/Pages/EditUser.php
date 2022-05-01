<?php

namespace RyanChandler\FilamentUserResource\Resources\UserResource\Pages;

use RyanChandler\FilamentUserResource\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    public function beforeSave()
    {
        if (! filled($this->data['new_password'])) {
            return;
        }

        $this->record->password = Hash::make($this->data['new_password']);
    }
}
