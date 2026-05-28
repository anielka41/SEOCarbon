<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\Directory\Models\DirectoryCategory;
use App\Services\Seo\JsonLdGenerator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

final class DirectoryCategoryController extends Controller
{
    public function __construct(private readonly Factory $factory) {}

    public function show(DirectoryCategory $directoryCategory, JsonLdGenerator $jsonLd): View
    {
        $lengthAwarePaginator = $directoryCategory->entries()->where('status', 'published')->paginate(15);
        $schema = $jsonLd->generateForDirectoryCategory($directoryCategory);

        return $this->factory->make('categories.show', [
            'category' => $directoryCategory,
            'listings' => $lengthAwarePaginator,
            'schema' => $schema,
        ]);
    }
}
