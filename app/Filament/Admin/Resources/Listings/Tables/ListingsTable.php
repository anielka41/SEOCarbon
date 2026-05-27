<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Listings\Tables;

use App\Enums\EntryStatus;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Filters\SelectFilter;

final class ListingsTable
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
                    ->label(strval(__('Category'))),

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
                    ->label(strval(__('Category'))),
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
