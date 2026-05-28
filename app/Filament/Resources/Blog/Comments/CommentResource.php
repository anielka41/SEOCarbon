<?php

declare(strict_types=1);

namespace App\Filament\Resources\Blog\Comments;

use App\Domain\Blog\Models\PostComment;
use App\Filament\Resources\Blog\Comments\Pages\ListComments;
use App\Filament\Resources\Blog\Comments\Schemas\CommentSchema;
use App\Filament\Resources\Blog\Comments\Tables\CommentsTable;
use BackedEnum;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;
use UnitEnum;

final class CommentResource extends Resource
{
    #[Override]
    protected static ?string $model = PostComment::class;

    #[Override]
    protected static ?string $slug = 'comments';

    #[Override]
    protected static ?string $recordTitleAttribute = 'id';

    #[Override]
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    #[Override]
    protected static string|UnitEnum|null $navigationGroup = 'Moderation';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return CommentSchema::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return CommentsTable::configure($table);
    }

    /**
     * @return PageRegistration[]
     */
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListComments::route('/'),
        ];
    }
}
