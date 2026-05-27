<?php

declare(strict_types=1);

namespace App\Filament\Dashboard\Resources\MyListings\Tables;

use App\Enums\EntryStatus;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteBulkAction;

final class MyListingsTable
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
                    ->limit(30)
                    ->label(strval(__('URL'))),

                TextColumn::make('status')
                    ->badge()
                    ->label(strval(__('Status'))),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(strval(__('Created At'))),
            ])
            ->filters([
                //
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
