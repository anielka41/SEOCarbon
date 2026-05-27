<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Listings\Schemas;

use App\Enums\EntryStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

final class ListingSchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(strval(__('Listing Details')))
                ->schema([
                    Select::make('category_id')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->label(strval(__('Category'))),

                    TextInput::make('name')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? '')))
                        ->label(strval(__('Name'))),

                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->label(strval(__('Slug'))),

                    TextInput::make('url')
                        ->required()
                        ->url()
                        ->unique(ignoreRecord: true)
                        ->label(strval(__('URL'))),

                    Textarea::make('description')
                        ->required()
                        ->columnSpanFull()
                        ->label(strval(__('Description'))),

                    Select::make('status')
                        ->options(EntryStatus::class)
                        ->required()
                        ->label(strval(__('Status'))),

                    Toggle::make('is_promoted')
                        ->default(false)
                        ->label(strval(__('Is Promoted'))),
                ])
                ->columns(2),
        ]);
    }
}
