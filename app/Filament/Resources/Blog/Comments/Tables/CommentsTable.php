<?php

declare(strict_types=1);

namespace App\Filament\Resources\Blog\Comments\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

final class CommentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label(strval(__('Author'))),

                TextColumn::make('commentable_type')
                    ->label(strval(__('Type'))),

                TextColumn::make('rating')
                    ->sortable()
                    ->label(strval(__('Rating'))),

                TextColumn::make('content')
                    ->limit(50)
                    ->searchable()
                    ->label(strval(__('Content'))),

                IconColumn::make('is_approved')
                    ->boolean()
                    ->sortable()
                    ->label(strval(__('Approved'))),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label(strval(__('Created At'))),
            ])
            ->filters([
                TernaryFilter::make('is_approved')
                    ->label(strval(__('Approval Status'))),
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
