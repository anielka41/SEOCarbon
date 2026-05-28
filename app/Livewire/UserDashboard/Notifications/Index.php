<?php

declare(strict_types=1);

namespace App\Livewire\UserDashboard\Notifications;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.dashboard')]
#[Title('Notifications')]
final class Index extends Component
{
    public function render(Factory $factory): View
    {
        return $factory->make('livewire.user-dashboard.page', [
            'heading' => __('Notifications'),
            'description' => __('Tu będą trafiać komunikaty o moderacji, płatnościach i odnowieniach wyróżnień.'),
            'primaryActionLabel' => __('View Entries'),
            'primaryActionRoute' => 'dashboard.entries.index',
        ]);
    }
}
