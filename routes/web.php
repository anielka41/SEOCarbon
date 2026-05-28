<?php

declare(strict_types=1);

use App\Http\Controllers\DirectoryCategoryController;
use App\Http\Controllers\DirectoryEntryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReadyController;
use App\Livewire\UserDashboard\Entries\Create as DashboardCreateEntry;
use App\Livewire\UserDashboard\Entries\Edit as DashboardEditEntry;
use App\Livewire\UserDashboard\Entries\Index as DashboardEntriesIndex;
use App\Livewire\UserDashboard\Notifications\Index as DashboardNotificationsIndex;
use App\Livewire\UserDashboard\Overview;
use App\Livewire\UserDashboard\Payments\Index as DashboardPaymentsIndex;
use App\Livewire\UserDashboard\Privacy\Index as DashboardPrivacyIndex;
use App\Livewire\UserDashboard\Profile\Edit as DashboardProfileEdit;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn (): Factory|View => view('welcome'));

Route::middleware(['auth'])->group(function (): void {
    Route::get('/dashboard', Overview::class)->name('dashboard');
    Route::get('/dashboard/entries', DashboardEntriesIndex::class)->name('dashboard.entries.index');
    Route::get('/dashboard/entries/create', DashboardCreateEntry::class)->name('dashboard.entries.create');
    Route::get('/dashboard/entries/{entry}/edit', DashboardEditEntry::class)->name('dashboard.entries.edit');
    Route::get('/dashboard/payments', DashboardPaymentsIndex::class)->name('dashboard.payments.index');
    Route::get('/dashboard/notifications', DashboardNotificationsIndex::class)->name('dashboard.notifications.index');
    Route::get('/dashboard/profile', DashboardProfileEdit::class)->name('dashboard.profile.edit');
    Route::get('/dashboard/privacy', DashboardPrivacyIndex::class)->name('dashboard.privacy.index');

    Route::redirect('/dashboard/my-listings/create', '/dashboard/entries/create');

    Route::post('/logout', function (Request $request): Redirector|RedirectResponse {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    })->name('logout');
});

Route::get('/login', fn () => to_route('filament.admin.auth.login'))->name('login');

Route::get('/ready', ReadyController::class)->name('ready');

Route::get('/listings/{listing:slug}', [DirectoryEntryController::class, 'show'])->name('listings.show');
Route::get('/categories/{category:slug}', [DirectoryCategoryController::class, 'show'])->name('categories.show');
Route::get('/blog/{post:slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/img/{path}', [ImageController::class, 'show'])->where('path', '.*')->name('image.show');
