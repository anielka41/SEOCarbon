<?php

declare(strict_types=1);

namespace App\Filament\Resources\Blog\Posts\Tables;

use App\Enums\EntryStatus;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

final class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->label(strval(__('Image'))),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label(strval(__('Title'))),

                TextColumn::make('category.name')
                    ->sortable()
                    ->label(strval(__('DirectoryCategory'))),

                TextColumn::make('user.name')
                    ->sortable()
                    ->label(strval(__('Author'))),

                TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->label(strval(__('Status'))),

                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->label(strval(__('Published At'))),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(strval(__('Created At'))),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(EntryStatus::class),
                SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label(strval(__('DirectoryCategory'))),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
