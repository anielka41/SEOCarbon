<?php

declare(strict_types=1);

namespace App\Filament\Resources\Payments\Invoices\Pages;

use App\Filament\Resources\Payments\Invoices\InvoiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Override;

final class ListInvoices extends ListRecords
{
    #[Override]
    protected static string $resource = InvoiceResource::class;

    /**
     * @return CreateAction[]
     */
    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
