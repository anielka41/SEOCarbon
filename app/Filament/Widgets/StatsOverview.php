<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Domain\Blog\Models\Post;
use App\Domain\Blog\Models\PostComment;
use App\Domain\Directory\Models\DirectoryEntry;
use App\Domain\Users\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Override;

final class StatsOverview extends BaseWidget
{
    /**
     * @return Stat[]
     */
    #[Override]
    protected function getStats(): array
    {
        return [
            Stat::make(strval(__('Total Users')), User::query()->count()),
            Stat::make(strval(__('Total DirectoryEntries')), DirectoryEntry::query()->count()),
            Stat::make(strval(__('Total Posts')), Post::query()->count()),
            Stat::make(strval(__('Pending Comments')), PostComment::query()->where('is_approved', false)->count()),
        ];
    }
}
