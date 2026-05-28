<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\BacklinkChecks\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class BacklinkCheckSchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Check Details')
                    ->schema([
                        Select::make('directory_entry_id')
                            ->relationship('entry', 'name')
                            ->required()
                            ->searchable(),
                        TextInput::make('status')
                            ->disabled(),
                        DateTimePicker::make('checked_at')
                            ->disabled(),
                        TextInput::make('error_message')
                            ->columnSpanFull()
                            ->disabled(),
                    ])->columns(2),
            ]);
    }
}
