<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Permissions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class PermissionSchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Permission Details')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('guard_name')
                            ->required()
                            ->maxLength(255)
                            ->default('web'),
                    ])->columns(2),
            ]);
    }
}
