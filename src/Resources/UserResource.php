<?php

namespace RyanChandler\FilamentUserResource\Resources;

use RyanChandler\FilamentUserResource\Resources\UserResource\Pages;
use RyanChandler\FilamentUserResource\Resources\UserResource\RelationManagers;
use App\Models\User;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\Rules\Password;
use RyanChandler\FilamentUserResource\Resources\UserResource\Pages\CreateUser;

class UserResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static bool | Closure $enablePasswordUpdates = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    TextInput::make('name')
                        ->required(),
                    TextInput::make('email')
                        ->required()
                        ->unique(ignoreRecord: true),
                    TextInput::make('password')
                        ->required()
                        ->password()
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->visible(fn ($livewire) => $livewire instanceof CreateUser)
                        ->rule(Password::default()),
                    Group::make([
                        TextInput::make('new_password')
                            ->password()
                            ->label('New Password')
                            ->nullable()
                            ->rule(Password::default())
                            ->dehydrated(false),
                        TextInput::make('new_password_confirmation')
                            ->password()
                            ->label('Confirm New Password')
                            ->rule('required', fn ($get) => !! $get('new_password'))
                            ->same('new_password')
                            ->dehydrated(false),
                    ])->visible(static::$enablePasswordUpdates)
                ])->columnSpan(8),
                Card::make([
                    Placeholder::make('created_at')
                        ->content(fn ($record) => $record?->created_at?->diffForHumans() ?? new HtmlString('&mdash;'))
                ])->columnSpan(4),
            ])
            ->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function enablePasswordUpdates(bool | Closure $condition = true): void
    {
        static::$enablePasswordUpdates = $condition;
    }

    public static function getModel(): string
    {
        return config('filament-user-resource.model');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
