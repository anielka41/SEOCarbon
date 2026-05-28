<?php

declare(strict_types=1);

namespace App\Filament\Resources\Payments\Invoices;

use App\Domain\Payments\Models\Invoice;
use App\Filament\Resources\Payments\Invoices\Pages\CreateInvoice;
use App\Filament\Resources\Payments\Invoices\Pages\EditInvoice;
use App\Filament\Resources\Payments\Invoices\Pages\ListInvoices;
use App\Filament\Resources\Payments\Invoices\Pages\ViewInvoice;
use App\Filament\Resources\Payments\Invoices\Schemas\InvoiceSchema;
use App\Filament\Resources\Payments\Invoices\Tables\InvoicesTable;
use BackedEnum;
use Filament\Infolists\Components\Section as InfolistSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;
use UnitEnum;

final class InvoiceResource extends Resource
{
    #[Override]
    protected static ?string $model = Invoice::class;

    #[Override]
    protected static ?string $slug = 'invoices';

    #[Override]
    protected static ?string $recordTitleAttribute = 'number';

    #[Override]
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    #[Override]
    protected static string|UnitEnum|null $navigationGroup = 'Payments';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return InvoiceSchema::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return InvoicesTable::configure($table);
    }

    #[Override]
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistSection::make(strval(__('Invoice Details')))
                    ->schema([
                        TextEntry::make('number')
                            ->label(strval(__('Number'))),
                        TextEntry::make('user.name')
                            ->label(strval(__('User'))),
                        TextEntry::make('listing.name')
                            ->label(strval(__('DirectoryEntry'))),
                        TextEntry::make('currency')
                            ->label(strval(__('Currency'))),
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'draft' => 'gray',
                                'issued' => 'info',
                                'confirmed' => 'success',
                                'cancelled' => 'danger',
                                default => 'gray',
                            })
                            ->label(strval(__('Status'))),
                    ])->columns(2),

                InfolistSection::make(strval(__('Financials')))
                    ->schema([
                        TextEntry::make('amount_net')
                            ->money(fn ($record) => $record->currency)
                            ->label(strval(__('Amount Net'))),
                        TextEntry::make('amount_vat')
                            ->money(fn ($record) => $record->currency)
                            ->label(strval(__('Amount VAT'))),
                        TextEntry::make('amount_gross')
                            ->money(fn ($record) => $record->currency)
                            ->label(strval(__('Amount Gross'))),
                    ])->columns(3),
            ]);
    }

    #[Override]
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    /**
     * @return array<string, PageRegistration>
     */
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListInvoices::route('/'),
            'create' => CreateInvoice::route('/create'),
            'view' => ViewInvoice::route('/{record}'),
            'edit' => EditInvoice::route('/{record}/edit'),
        ];
    }
}
