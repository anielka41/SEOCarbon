<?php

declare(strict_types=1);

namespace App\Filament\Resources\Payments\Invoices\Pages;

use App\Filament\Resources\Payments\Invoices\InvoiceResource;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditInvoice extends EditRecord
{
    #[Override]
    protected static string $resource = InvoiceResource::class;
}
