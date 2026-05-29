<?php

declare(strict_types=1);

namespace App\Filament\Resources\Settings\Settings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class SettingSchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(strval(__('Setting Details')))
                    ->schema([
                        TextInput::make('key')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->label(strval(__('Key'))),

                        TextInput::make('group')
                            ->required()
                            ->maxLength(255)
                            ->default('general')
                            ->label(strval(__('Group'))),

                        Select::make('type')
                            ->options([
                                'string' => 'String',
                                'text' => 'Text',
                                'boolean' => 'Boolean',
                                'number' => 'Number',
                                'json' => 'JSON',
                            ])
                            ->required()
                            ->label(strval(__('Type'))),

                        Toggle::make('is_public')
                            ->label(strval(__('Is Public'))),

                        Textarea::make('value')
                            ->columnSpanFull()
                            ->label(strval(__('Value'))),

                        Textarea::make('description')
                            ->columnSpanFull()
                            ->label(strval(__('Description'))),
                    ])->columns(2),
            ]);
    }
}
