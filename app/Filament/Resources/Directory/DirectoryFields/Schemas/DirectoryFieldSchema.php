<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryFields\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

final class DirectoryFieldSchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(strval(__('Field Details')))
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state): mixed => $set('label', Str::title(str_replace('_', ' ', $state ?? ''))))
                        ->label(strval(__('Technical Name (slug)'))),

                    TextInput::make('label')
                        ->required()
                        ->label(strval(__('Display Label'))),

                    Select::make('type')
                        ->options([
                            'text' => 'Text',
                            'textarea' => 'Textarea',
                            'number' => 'Number',
                            'select' => 'Select',
                            'multi_select' => 'Multi Select',
                            'checkbox' => 'Checkbox',
                            'date' => 'Date',
                        ])
                        ->required()
                        ->label(strval(__('Field Type'))),

                    TextInput::make('placeholder')
                        ->label(strval(__('Placeholder'))),

                    TextInput::make('help_text')
                        ->label(strval(__('Help Text'))),

                    TextInput::make('sort_order')
                        ->numeric()
                        ->default(0)
                        ->label(strval(__('Sort Order'))),

                    Toggle::make('is_required')
                        ->label(strval(__('Is Required'))),

                    Toggle::make('is_searchable')
                        ->default(true)
                        ->label(strval(__('Is Searchable'))),

                    Toggle::make('is_filterable')
                        ->label(strval(__('Is Filterable'))),
                ])
                ->columns(2),

            Section::make(strval(__('Associations')))
                ->schema([
                    Select::make('categories')
                        ->relationship('categories', 'name')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->label(strval(__('Applied to Categories'))),

                    Select::make('groups')
                        ->relationship('groups', 'name')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->label(strval(__('Applied to Groups'))),
                ])
                ->columns(2),
        ]);
    }
}
