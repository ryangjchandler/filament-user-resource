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

    protected static Closure | null $extendFormCallback = null;

    protected static ?string $navigationLabel = null;

    protected static ?string $modelLabel = null;

    protected static ?string $pluralModelLabel = null;

    public static function extendForm(Closure $callback): void
    {
        static::$extendFormCallback = $callback;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(function () {
                $schema = [
                    'left' => Card::make([
                        'name' => TextInput::make('name')
                            ->required()
                            ->label(__('filament-user-resource::filament-user-resource.attributes.name')),
                        'email' => TextInput::make('email')
                            ->required()
                            ->unique(ignoreRecord: true),
                        'password' => TextInput::make('password')
                            ->required()
                            ->label(__('filament-user-resource::filament-user-resource.attributes.password'))
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->visible(fn ($livewire) => $livewire instanceof CreateUser)
                            ->rule(Password::default()),
                        'new_password_group' => Group::make([
                            'new_password' => TextInput::make('new_password')
                                ->password()
                                ->label(__('filament-user-resource::filament-user-resource.attributes.new_password'))
                                ->nullable()
                                ->rule(Password::default())
                                ->dehydrated(false),
                            'new_password_confirmation' => TextInput::make('new_password_confirmation')
                                ->password()
                                ->label(__('filament-user-resource::filament-user-resource.attributes.new_password_confirmation'))
                                ->rule('required', fn ($get) => !! $get('new_password'))
                                ->same('new_password')
                                ->dehydrated(false),
                        ])->visible(static::$enablePasswordUpdates)
                    ])->columnSpan(8),
                    'right' => Card::make([
                        'created_at' => Placeholder::make('created_at')
                            ->label(__('filament-user-resource::filament-user-resource.attributes.created_at'))
                            ->content(fn ($record) => $record?->created_at?->diffForHumans() ?? new HtmlString('&mdash;'))
                    ])->columnSpan(4),
                ];

                if (static::$extendFormCallback !== null) {
                    $schema = value(static::$extendFormCallback, $schema);
                }

                return $schema;
            })
            ->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->label(__('filament-user-resource::filament-user-resource.attributes.name')),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label(__('filament-user-resource::filament-user-resource.attributes.created_at')),
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

    public static function navigationLabel(?string $string): void
    {
        self::$navigationLabel = $string;
    }

    public static function pluralLabel(?string $string): void
    {
        self::$pluralModelLabel = $string;
    }

    public static function label(?string $string): void
    {
        self::$modelLabel = $string;
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
