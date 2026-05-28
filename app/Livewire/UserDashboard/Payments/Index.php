<?php

declare(strict_types=1);

namespace App\Livewire\UserDashboard\Payments;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.dashboard')]
#[Title('Payments')]
final class Index extends Component
{
    public function render(Factory $factory): View
    {
        return $factory->make('livewire.user-dashboard.page', [
            'heading' => __('Payments'),
            'description' => __('Tu pojawią się płatności, faktury i statusy rozliczeń dla Twoich wpisów oraz wyróżnień.'),
            'primaryActionLabel' => __('Add Entry'),
            'primaryActionRoute' => 'dashboard.entries.create',
        ]);
    }
}
