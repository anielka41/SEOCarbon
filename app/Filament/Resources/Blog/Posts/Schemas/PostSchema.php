<?php

declare(strict_types=1);

namespace App\Filament\Resources\Blog\Posts\Schemas;

use App\Enums\EntryStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

final class PostSchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(strval(__('Post Details')))
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state): mixed => $set('slug', Str::slug($state ?? '')))
                        ->label(strval(__('Title'))),

                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->label(strval(__('Slug'))),

                    Select::make('category_id')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->label(strval(__('DirectoryCategory'))),

                    Select::make('tags')
                        ->relationship('tags', 'name')
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            TextInput::make('name')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Set $set, ?string $state): mixed => $set('slug', Str::slug($state ?? ''))),
                            TextInput::make('slug')
                                ->required()
                                ->unique('tags', 'slug'),
                        ])
                        ->label(strval(__('Tags'))),

                    Select::make('user_id')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload()
                        ->default(auth()->id())
                        ->required()
                        ->label(strval(__('Author'))),

                    Textarea::make('excerpt')
                        ->columnSpanFull()
                        ->label(strval(__('Excerpt'))),

                    RichEditor::make('content')
                        ->required()
                        ->columnSpanFull()
                        ->label(strval(__('Content'))),

                    FileUpload::make('featured_image')
                        ->image()
                        ->directory('posts')
                        ->visibility('public')
                        ->label(strval(__('Featured Image'))),

                    Select::make('status')
                        ->options(EntryStatus::class)
                        ->required()
                        ->label(strval(__('Status'))),

                    DateTimePicker::make('published_at')
                        ->label(strval(__('Published At'))),
                ])
                ->columns(2),

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
