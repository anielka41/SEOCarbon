<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Roles\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class RoleSchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(strval(__('Role Details')))
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->label(strval(__('Name'))),
                        TextInput::make('guard_name')
                            ->required()
                            ->maxLength(255)
                            ->default('web')
                            ->label(strval(__('Guard Name'))),
                        Select::make('permissions')
                            ->relationship('permissions', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->label(strval(__('Permissions'))),
                    ])->columns(2),
            ]);
    }
}
