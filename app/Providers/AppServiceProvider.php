<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Ai\ContentEnrichmentService;
use App\Services\Ai\Contracts\AiProvider;
use App\Services\Ai\Providers\MockAiProvider;
use App\Services\Ksef\Contracts\KsefServiceContract;
use App\Services\Ksef\KsefService;
use Illuminate\Support\ServiceProvider;
use Override;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[Override]
    public function register(): void
    {
        $this->app->singleton(AiProvider::class, MockAiProvider::class);
        $this->app->singleton(ContentEnrichmentService::class);
        $this->app->singleton(KsefServiceContract::class, KsefService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            return $user->hasRole(\App\Domain\Users\Enums\UserRole::SuperAdmin->value) ? true : null;
        });
    }
}
