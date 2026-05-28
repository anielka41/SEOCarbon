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
                Section::make(strval(__('Check Details')))
                    ->schema([
                        Select::make('directory_entry_id')
                            ->relationship('entry', 'name')
                            ->required()
                            ->searchable()
                            ->label(strval(__('Entry'))),
                        TextInput::make('status')
                            ->disabled()
                            ->label(strval(__('Status'))),
                        DateTimePicker::make('checked_at')
                            ->disabled()
                            ->label(strval(__('Checked At'))),
                        TextInput::make('error_message')
                            ->columnSpanFull()
                            ->disabled()
                            ->label(strval(__('Error Message'))),
                    ])->columns(2),
            ]);
    }
}
