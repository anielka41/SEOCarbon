<?php

declare(strict_types=1);

namespace App\Providers;

use App\Domain\Directory\Models\DirectoryEntry;
use App\Policies\DirectoryEntryPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::policy(DirectoryEntry::class, DirectoryEntryPolicy::class);
    }
}
