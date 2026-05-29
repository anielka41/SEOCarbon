<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryCategories\Tables;

use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

final class DirectoryCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(strval(__('Name'))),

                TextColumn::make('type')
                    ->badge()
                    ->sortable()
                    ->label(strval(__('Type'))),

                TextColumn::make('parent.name')
                    ->sortable()
                    ->label(strval(__('Parent DirectoryCategory'))),

                TextColumn::make('slug')
                    ->searchable()
                    ->label(strval(__('Slug'))),

                TextColumn::make('entries_count')
                    ->counts('entries')
                    ->label(strval(__('DirectoryEntries'))),

                TextColumn::make('posts_count')
                    ->counts('posts')
                    ->label(strval(__('Posts'))),

                IconColumn::make('is_active')
                    ->boolean()
                    ->label(strval(__('Active'))),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(strval(__('Created At'))),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'directory' => strval(__('Directory')),
                        'blog' => strval(__('Blog')),
                    ]),
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
