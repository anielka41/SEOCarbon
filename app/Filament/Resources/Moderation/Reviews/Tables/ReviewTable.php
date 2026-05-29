<?php

declare(strict_types=1);

namespace App\Filament\Resources\Moderation\Reviews\Tables;

use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

final class ReviewTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reviewable_type')
                    ->label(strval(__('Target Type')))
                    ->formatStateUsing(fn (string $state): string => str_replace(['App\Domain\Directory\Models\\', 'App\Domain\Blog\Models\\'], '', $state))
                    ->badge(),
                TextColumn::make('author_name')
                    ->label(strval(__('Author')))
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->author_email),
                TextColumn::make('rating')
                    ->label(strval(__('Rating')))
                    ->numeric()
                    ->sortable()
                    ->color('warning'),
                TextColumn::make('status')
                    ->label(strval(__('Status')))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'spam' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => strval(__('Pending')),
                        'approved' => strval(__('Approved')),
                        'rejected' => strval(__('Rejected')),
                        'spam' => strval(__('Spam')),
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
