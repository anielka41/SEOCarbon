<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryEntries\Schemas;

use App\Domain\Blog\Models\Tag;
use App\Domain\Directory\Models\DirectoryCategory;
use App\Domain\Directory\Models\DirectoryGroup;
use App\Enums\EntryStatus;
use App\Services\Ai\ContentEnrichmentService;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
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

final class DirectoryEntrySchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(strval(__('DirectoryEntry Details')))
                ->schema([
                    Select::make('category_id')
                        ->relationship('category', 'name', modifyQueryUsing: fn (Builder $builder) => $builder->where('type', 'directory'))
                        ->searchable()
                        ->preload()
                        ->required()
                        ->label(strval(__('DirectoryCategory'))),

                    Select::make('package_id')
                        ->relationship('package', 'name', modifyQueryUsing: fn (Builder $builder) => $builder->where('is_active', true))
                        ->searchable()
                        ->preload()
                        ->live()
                        ->label(strval(__('DirectoryGroup'))),

                    TextInput::make('name')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state): mixed => $set('slug', Str::slug($state ?? '')))
                        ->label(strval(__('Name'))),

                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->label(strval(__('Slug'))),

                    TextInput::make('url')
                        ->required()
                        ->url()
                        ->unique(ignoreRecord: true)
                        ->suffixAction(
                            Action::make('enrich')
                                ->icon('heroicon-m-sparkles')
                                ->tooltip(strval(__('Enrich with AI')))
                                ->action(function (Set $set, ?string $state, ContentEnrichmentService $contentEnrichmentService): void {
                                    if (! $state) {
                                        return;
                                    }

                                    $data = $contentEnrichmentService->enrichFromUrl($state);

                                    if ($data !== []) {
                                        $set('name', $data['name'] ?? null);
                                        $set('description', $data['description'] ?? null);
                                        $set('contact_email', $data['contact_email'] ?? null);
                                        $set('contact_phone', $data['contact_phone'] ?? null);
                                        $set('address', $data['address'] ?? null);

                                        if (isset($data['category_suggestion'])) {
                                            $directoryCategory = DirectoryCategory::query()->where('name', 'like', sprintf('%%%s%%', $data['category_suggestion']))
                                                ->where('type', 'directory')
                                                ->first();
                                            if ($directoryCategory) {
                                                $set('category_id', $directoryCategory->id);
                                            }
                                        }

                                        if (isset($data['tags']) && is_array($data['tags'])) {
                                            $tagIds = [];
                                            foreach ($data['tags'] as $tagName) {
                                                $tag = Tag::query()->firstOrCreate(['name' => $tagName], ['slug' => Str::slug($tagName)]);
                                                $tagIds[] = $tag->id;
                                            }

                                            $set('tags', $tagIds);
                                        }
                                    }
                                })
                        )
                        ->label(strval(__('URL'))),

                    TextInput::make('backlink_url')
                        ->url()
                        ->required(fn (Get $get): bool => $get('package_id') && (DirectoryGroup::query()->find($get('package_id'))?->requires_backlink ?? false))
                        ->disabled(fn (Get $get): bool => ! ($get('package_id') && (
                            ($group = DirectoryGroup::query()->find($get('package_id'))) && ($group->requires_backlink || $group->can_add_backlink)
                        )))
                        ->label(strval(__('Backlink URL'))),

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

                    FileUpload::make('logo_path')
                        ->image()
                        ->directory('listings/logos')
                        ->visibility('public')
                        ->disabled(fn (Get $get): bool => ! ($get('package_id') && (DirectoryGroup::query()->find($get('package_id'))?->can_upload_logo ?? false)))
                        ->label(strval(__('Logo'))),

                    FileUpload::make('thumbnail_path')
                        ->image()
                        ->directory('listings/thumbnails')
                        ->visibility('public')
                        ->disabled(fn (Get $get): bool => ! ($get('package_id') && (DirectoryGroup::query()->find($get('package_id'))?->can_upload_thumbnail ?? false)))
                        ->label(strval(__('Thumbnail'))),
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
