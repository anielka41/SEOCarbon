<?php

declare(strict_types=1);

namespace App\Filament\Resources\Blog\Tags;

use App\Domain\Blog\Models\Tag;
use App\Filament\Resources\Blog\Tags\Pages\CreateTag;
use App\Filament\Resources\Blog\Tags\Pages\EditTag;
use App\Filament\Resources\Blog\Tags\Pages\ListTags;
use App\Filament\Resources\Blog\Tags\Schemas\TagSchema;
use App\Filament\Resources\Blog\Tags\Tables\TagsTable;
use BackedEnum;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;
use UnitEnum;

final class TagResource extends Resource
{
    #[Override]
    protected static ?string $model = Tag::class;

    #[Override]
    protected static ?string $slug = 'tags';

    #[Override]
    protected static ?string $recordTitleAttribute = 'name';

    #[Override]
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    #[Override]
    protected static string|UnitEnum|null $navigationGroup = 'Content';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return TagSchema::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return TagsTable::configure($table);
    }

    /**
     * @return array<string, PageRegistration>
     */
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListTags::route('/'),
            'create' => CreateTag::route('/create'),
            'edit' => EditTag::route('/{record}/edit'),
        ];
    }
}
