<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\Directory\Models\DirectoryEntry;
use App\Services\Seo\JsonLdGenerator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

final class DirectoryEntryController extends Controller
{
    public function __construct(private readonly Factory $factory) {}

    public function show(DirectoryEntry $directoryEntry, JsonLdGenerator $jsonLd): View
    {
        $schema = $jsonLd->generateForDirectoryEntry($directoryEntry);

        return $this->factory->make('listings.show', [
            'listing' => $directoryEntry,
            'schema' => $schema,
        ]);
    }
}
