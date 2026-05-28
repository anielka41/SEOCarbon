<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Modules\Licensing\Services\LicenseVerificationService;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

final class ReadyController extends Controller
{
    public function __construct(private readonly LicenseVerificationService $licenseVerificationService, private readonly ResponseFactory $responseFactory, private readonly Repository $repository) {}

    public function __invoke(): JsonResponse
    {
        $checks = [
            'database' => $this->checkDatabase(),
            'cache' => $this->checkCache(),
            'redis' => $this->checkRedis(),
            'license' => $this->checkLicense(),
        ];

        $healthy = ! in_array(false, $checks, true);

        return $this->responseFactory->json([
            'ok' => $healthy,
            'checks' => $checks,
        ], $healthy ? 200 : 503);
    }

    private function checkDatabase(): bool
    {
        try {
            DB::select('select 1');

            return true;
        } catch (Throwable) {
            return false;
        }
    }

    private function checkCache(): bool
    {
        try {
            $store = Cache::store();
            $key = 'ready-check:'.Str::uuid()->toString();
            $store->put($key, 'ok', 10);

            return $store->get($key) === 'ok' && $store->forget($key);
        } catch (Throwable) {
            return false;
        }
    }

    private function checkRedis(): bool
    {
        $redisConfig = $this->repository->get('cache.stores.redis');

        if (! is_array($redisConfig)) {
            return true;
        }

        try {
            $store = Cache::store('redis');
            $key = 'ready-check:'.Str::uuid()->toString();
            $store->put($key, 'ok', 10);

            return $store->get($key) === 'ok' && $store->forget($key);
        } catch (Throwable) {
            return false;
        }
    }

    private function checkLicense(): bool
    {
        try {
            return $this->licenseVerificationService->verify(base_path('license.key'));
        } catch (Throwable) {
            return false;
        }
    }
}
