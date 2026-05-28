<?php

declare(strict_types=1);

namespace App\Livewire\UserDashboard\Privacy;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.dashboard')]
#[Title('Privacy')]
final class Index extends Component
{
    public function render(Factory $factory): View
    {
        return $factory->make('livewire.user-dashboard.page', [
            'heading' => __('Privacy'),
            'description' => __('Eksport danych, usuwanie konta i zgody prywatności znajdziesz tutaj.'),
            'primaryActionLabel' => __('Notifications'),
            'primaryActionRoute' => 'dashboard.notifications.index',
        ]);
    }
}
