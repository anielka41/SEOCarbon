<?php

declare(strict_types=1);

namespace App\Filament\Resources\Blog\Posts;

use App\Domain\Blog\Models\Post;
use App\Filament\Resources\Blog\Posts\Pages\CreatePost;
use App\Filament\Resources\Blog\Posts\Pages\EditPost;
use App\Filament\Resources\Blog\Posts\Pages\ListPosts;
use App\Filament\Resources\Blog\Posts\Schemas\PostSchema;
use App\Filament\Resources\Blog\Posts\Tables\PostsTable;
use BackedEnum;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;
use UnitEnum;

final class PostResource extends Resource
{
    #[Override]
    protected static ?string $model = Post::class;

    #[Override]
    protected static ?string $slug = 'posts';

    #[Override]
    protected static ?string $recordTitleAttribute = 'title';

    #[Override]
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    #[Override]
    protected static string|UnitEnum|null $navigationGroup = 'Content';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return PostSchema::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return PostsTable::configure($table);
    }

    /**
     * @return array<string, PageRegistration>
     */
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }
}
