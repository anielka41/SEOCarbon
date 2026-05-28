<?php

declare(strict_types=1);

namespace App\Filament\Resources\Payments\Invoices\Pages;

use App\Filament\Resources\Payments\Invoices\InvoiceResource;
use Filament\Resources\Pages\ViewRecord;
use Override;

final class ViewInvoice extends ViewRecord
{
    #[Override]
    protected static string $resource = InvoiceResource::class;
}
