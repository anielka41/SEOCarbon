<?php

declare(strict_types=1);

namespace App\Filament\Resources\Payments\Invoices\Tables;

use App\Domain\Payments\Models\Invoice;
use App\Services\Ksef\Contracts\KsefServiceContract;
use Exception;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')
                    ->searchable()
                    ->sortable()
                    ->label(strval(__('Number'))),

                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label(strval(__('User'))),

                TextColumn::make('amount_gross')
                    ->money(fn ($record) => $record->currency)
                    ->sortable()
                    ->label(strval(__('Amount Gross'))),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'issued' => 'info',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->label(strval(__('Status'))),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label(strval(__('Created At'))),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    Action::make('sendToKsef')
                        ->label(strval(__('Send to KSeF')))
                        ->icon(Heroicon::PaperAirplane)
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (Invoice $invoice, KsefServiceContract $ksefServiceContract): void {
                            try {
                                $response = $ksefServiceContract->sendInvoice($invoice);

                                $invoice->update(['status' => 'issued']);

                                Notification::make()
                                    ->title(strval(__('Invoice sent to KSeF')))
                                    ->body(strval(__('Reference number: ')).($response['referenceNumber'] ?? 'N/A'))
                                    ->success()
                                    ->send();
                            } catch (Exception $exception) {
                                Notification::make()
                                    ->title(strval(__('Failed to send to KSeF')))
                                    ->body($exception->getMessage())
                                    ->danger()
                                    ->send();
                            }
                        }),
                    DeleteAction::make(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
