<?php

declare(strict_types=1);

namespace App\Livewire\UserDashboard\Profile;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.dashboard')]
#[Title('Profile')]
final class Edit extends Component
{
    public function render(Factory $factory): View
    {
        return $factory->make('livewire.user-dashboard.page', [
            'heading' => __('Profile'),
            'description' => __('Zarządzaj danymi konta, bezpieczeństwem i połączonymi metodami logowania.'),
            'primaryActionLabel' => __('Dashboard'),
            'primaryActionRoute' => 'dashboard',
        ]);
    }
}
