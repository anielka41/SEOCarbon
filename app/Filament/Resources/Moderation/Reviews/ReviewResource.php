<?php

declare(strict_types=1);

namespace App\Filament\Resources\Moderation\Reviews;

use App\Domain\Shared\Models\Review;
use App\Filament\Resources\Moderation\Reviews\Pages\CreateReview;
use App\Filament\Resources\Moderation\Reviews\Pages\EditReview;
use App\Filament\Resources\Moderation\Reviews\Pages\ListReviews;
use App\Filament\Resources\Moderation\Reviews\Schemas\ReviewSchema;
use App\Filament\Resources\Moderation\Reviews\Tables\ReviewTable;
use BackedEnum;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;
use UnitEnum;

final class ReviewResource extends Resource
{
    #[Override]
    protected static ?string $model = Review::class;

    #[Override]
    protected static ?string $slug = 'reviews';

    #[Override]
    protected static ?string $recordTitleAttribute = 'uuid';

    #[Override]
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;

    #[Override]
    protected static string|UnitEnum|null $navigationGroup = 'Moderation';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return ReviewSchema::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return ReviewTable::configure($table);
    }

    /**
     * @return array<string, PageRegistration>
     */
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListReviews::route('/'),
            'create' => CreateReview::route('/create'),
            'edit' => EditReview::route('/{record}/edit'),
        ];
    }
}
