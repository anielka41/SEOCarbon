<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Categories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

final class CategorySchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(strval(__('Category Details')))
                ->schema([
                    Select::make('parent_id')
                        ->relationship('parent', 'name')
                        ->searchable()
                        ->preload()
                        ->label(strval(__('Parent Category'))),

                    TextInput::make('name')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? '')))
                        ->label(strval(__('Name'))),

                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->label(strval(__('Slug'))),

                    Textarea::make('description')
                        ->columnSpanFull()
                        ->label(strval(__('Description'))),

                    TextInput::make('icon')
                        ->label(strval(__('Icon'))),

                    Toggle::make('is_active')
                        ->default(true)
                        ->label(strval(__('Is Active'))),
                ])
                ->columns(2),
        ]);
    }
}
