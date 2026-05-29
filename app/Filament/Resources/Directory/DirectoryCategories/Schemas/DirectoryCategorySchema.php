<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryCategories\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

final class DirectoryCategorySchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(strval(__('DirectoryCategory Details')))
                ->schema([
                    Select::make('type')
                        ->options([
                            'directory' => strval(__('Directory')),
                            'blog' => strval(__('Blog')),
                        ])
                        ->required()
                        ->live()
                        ->label(strval(__('Type'))),

                    Select::make('parent_id')
                        ->relationship(
                            'parent',
                            'name',
                            modifyQueryUsing: fn (Builder $builder) => $builder
                        )
                        ->searchable()
                        ->preload()
                        ->label(strval(__('Parent DirectoryCategory'))),

                    TextInput::make('name')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state): mixed => $set('slug', Str::slug($state ?? '')))
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
Section::make(strval(__('FAQ Schema')))
    ->schema([
        Repeater::make('faq')
            ->schema([
                TextInput::make('question')
                    ->required()
                    ->label(strval(__('Question'))),
                Textarea::make('answer')
                    ->required()
                    ->label(strval(__('Answer'))),
            ])
            ->columnSpanFull()
            ->label(strval(__('FAQ Items'))),
    ])
    ->collapsible(),

            Section::make(strval(__('SEO')))
                ->schema([
                    TextInput::make('meta_title')
                        ->maxLength(60)
                        ->label(strval(__('Meta Title'))),

                    Textarea::make('meta_description')
                        ->maxLength(160)
                        ->label(strval(__('Meta Description'))),
                ])
                ->collapsible(),
        ]);
    }
}
