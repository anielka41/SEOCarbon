<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DiagnosticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_dashboard_get(): void
    {
        $user = User::factory()->create();
        $testResponse = $this->actingAs($user)->get('/dashboard');
        $testResponse->assertOk();
    }
}
