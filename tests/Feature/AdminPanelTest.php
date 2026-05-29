<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_admin_can_access_dashboard(): void
    {
        $user = User::find(1);
        
        $this->actingAs($user)
            ->get('/admin')
            ->assertStatus(200);
    }

    public function test_admin_can_access_listings_edit(): void
    {
        $user = User::find(1);
        
        $this->actingAs($user)
            ->get('/admin/listings/1/edit')
            ->assertStatus(200);
    }
}
