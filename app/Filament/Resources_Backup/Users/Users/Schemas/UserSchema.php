<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Users\Schemas;

use App\Domain\Users\Enums\UserRole;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

final class UserSchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(strval(__('Basic Information')))
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label(strval(__('Name'))),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->label(strval(__('Email'))),
                        TextInput::make('password')
                            ->password()
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->maxLength(255)
                            ->label(strval(__('Password'))),
                    ])->columns(2),

                Section::make(strval(__('Roles & Status')))
                    ->schema([
                        Select::make('roles')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->label(strval(__('Roles'))),
                        DateTimePicker::make('email_verified_at')
                            ->label(strval(__('Email Verified At'))),
                    ])->columns(2),
            ]);
    }
}
