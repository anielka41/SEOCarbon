<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Categories\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteBulkAction;

final class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(strval(__('Name'))),

                TextColumn::make('parent.name')
                    ->sortable()
                    ->label(strval(__('Parent Category'))),

                TextColumn::make('slug')
                    ->searchable()
                    ->label(strval(__('Slug'))),

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
