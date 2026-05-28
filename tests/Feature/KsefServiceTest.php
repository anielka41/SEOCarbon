<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\Ksef\Contracts\KsefServiceContract;
use App\Services\Ksef\KsefService;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class KsefServiceTest extends TestCase
{
    public function test_ksef_service_is_registered(): void
    {
        $this->assertTrue(app()->bound(KsefServiceContract::class));
        $this->assertInstanceOf(KsefService::class, App::make(KsefServiceContract::class));
    }

    public function test_ksef_client_can_be_built(): void
    {
        $this->markTestSkipped('Skipping test that makes actual external KSeF API calls.');

        config(['services.ksef.nip' => '1234567890']);
        config(['services.ksef.token' => 'sample-token']);

        $ksefServiceContract = App::make(KsefServiceContract::class);
        $client = $ksefServiceContract->getClient();

        $this->assertNotNull($client);
    }
}
