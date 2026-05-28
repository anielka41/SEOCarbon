<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryGroups\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

final class DirectoryGroupSchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(strval(__('DirectoryGroup Details')))
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state): mixed => $set('slug', Str::slug($state ?? '')))
                        ->label(strval(__('Name'))),

                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->label(strval(__('Slug'))),

                    TextInput::make('price_net_amount')
                        ->numeric()
                        ->prefix('$')
                        ->required()
                        ->label(strval(__('Price Net (Minor Units)'))),

                    TextInput::make('currency')
                        ->required()
                        ->maxLength(3)
                        ->default('PLN')
                        ->label(strval(__('Currency'))),

                    TextInput::make('vat_rate')
                        ->numeric()
                        ->default(2300)
                        ->required()
                        ->label(strval(__('VAT Rate (Basis Points)'))),

                    Toggle::make('is_paid')
                        ->label(strval(__('Is Paid'))),

                    TextInput::make('duration_days')
                        ->numeric()
                        ->default(30)
                        ->required()
                        ->label(strval(__('Duration (Days)'))),

                    Textarea::make('description')
                        ->columnSpanFull()
                        ->label(strval(__('Description'))),
                ])
                ->columns(2),

            Section::make(strval(__('Features')))
                ->schema([
                    Toggle::make('can_upload_logo')
                        ->label(strval(__('Can Upload Logo'))),
                    Toggle::make('can_upload_thumbnail')
                        ->label(strval(__('Can Upload Thumbnail'))),
                    Toggle::make('can_add_backlink')
                        ->label(strval(__('Can Add Backlink'))),
                    Toggle::make('requires_backlink')
                        ->label(strval(__('Requires Backlink'))),
                    Toggle::make('auto_approve')
                        ->label(strval(__('Auto Approve'))),
                    Toggle::make('is_promoted')
                        ->label(strval(__('Is Promoted'))),
                    TextInput::make('max_images')
                        ->numeric()
                        ->default(1)
                        ->label(strval(__('Max Images'))),
                    TextInput::make('max_links')
                        ->numeric()
                        ->default(1)
                        ->label(strval(__('Max Links'))),
                    TextInput::make('max_tags')
                        ->numeric()
                        ->default(3)
                        ->label(strval(__('Max Tags'))),
                ])
                ->columns(2),

            Section::make(strval(__('Status')))
                ->schema([
                    Toggle::make('is_active')
                        ->default(true)
                        ->label(strval(__('Is Active'))),
                    TextInput::make('sort_order')
                        ->numeric()
                        ->default(0)
                        ->label(strval(__('Sort Order'))),
                    TextInput::make('sort_boost')
                        ->numeric()
                        ->default(0)
                        ->label(strval(__('Sort Boost'))),
                ])
                ->columns(2),
        ]);
    }
}
