<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryEntries\Tables;

use App\Enums\EntryStatus;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

final class DirectoryEntriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(strval(__('Name'))),

                TextColumn::make('category.name')
                    ->sortable()
                    ->label(strval(__('DirectoryCategory'))),

                TextColumn::make('url')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(strval(__('URL'))),

                TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->label(strval(__('Status'))),

                IconColumn::make('is_promoted')
                    ->boolean()
                    ->label(strval(__('Promoted'))),

                IconColumn::make('backlink_verified_at')
                    ->boolean()
                    ->label(strval(__('Backlink'))),

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
