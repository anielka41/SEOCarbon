<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-neutral-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }} - {{ __('User Dashboard') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full antialiased font-sans text-neutral-900">
    <div class="min-h-full">
        <!-- Sidebar for desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col lg:border-r lg:border-neutral-200 lg:bg-white lg:pt-5 lg:pb-4">
            <div class="flex flex-shrink-0 items-center px-6">
                <span class="text-xl font-bold tracking-tight">SEO<span class="text-primary-600 italic font-black">Carbon</span></span>
            </div>
            <!-- Navigation -->
            <nav class="mt-8 flex-1 space-y-1 px-3">
                <a href="{{ route('dashboard') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-700' : 'text-neutral-700 hover:bg-neutral-50 hover:text-neutral-900' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-primary-600' : 'text-neutral-400 group-hover:text-neutral-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    {{ __('Overview') }}
                </a>

                <a href="{{ route('dashboard.entries.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard.entries.*') ? 'bg-primary-50 text-primary-700' : 'text-neutral-700 hover:bg-neutral-50 hover:text-neutral-900' }}">
                    <svg class="mr-3 h-5 w-5 text-neutral-400 group-hover:text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    {{ __('My Listings') }}
                </a>

                <a href="{{ route('dashboard.payments.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard.payments.*') ? 'bg-primary-50 text-primary-700' : 'text-neutral-700 hover:bg-neutral-50 hover:text-neutral-900' }}">
                    <svg class="mr-3 h-5 w-5 text-neutral-400 group-hover:text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ __('Payments') }}
                </a>

                <a href="{{ route('dashboard.notifications.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard.notifications.*') ? 'bg-primary-50 text-primary-700' : 'text-neutral-700 hover:bg-neutral-50 hover:text-neutral-900' }}">
                    <svg class="mr-3 h-5 w-5 text-neutral-400 group-hover:text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.172V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C8.67 6.165 7 8.388 7 11v3.172c0 .538-.214 1.055-.595 1.438L5 17h5m5 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    {{ __('Notifications') }}
                </a>

                <a href="{{ route('dashboard.profile.edit') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard.profile.*') ? 'bg-primary-50 text-primary-700' : 'text-neutral-700 hover:bg-neutral-50 hover:text-neutral-900' }}">
                    <svg class="mr-3 h-5 w-5 text-neutral-400 group-hover:text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A1 1 0 016 17h12a1 1 0 01.879 1.516A9 9 0 115.121 17.804zM12 11a3 3 0 100-6 3 3 0 000 6z" />
                    </svg>
                    {{ __('Profile') }}
                </a>

                <a href="{{ route('dashboard.privacy.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard.privacy.*') ? 'bg-primary-50 text-primary-700' : 'text-neutral-700 hover:bg-neutral-50 hover:text-neutral-900' }}">
                    <svg class="mr-3 h-5 w-5 text-neutral-400 group-hover:text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 1.105-.895 2-2 2s-2-.895-2-2m4 0c0 1.105.895 2 2 2s2-.895 2-2m-6 0V7a2 2 0 114 0v4m-4 0h4m5 3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ __('Privacy') }}
                </a>
            </nav>
        </div>

        <!-- Main content -->
        <div class="flex flex-col lg:pl-64">
            <div class="sticky top-0 z-10 flex h-16 flex-shrink-0 border-b border-neutral-200 bg-white">
                <div class="flex flex-1 justify-between px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-1">
                        <!-- Mobile menu button -->
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-sm font-medium text-neutral-700">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm font-semibold text-neutral-500 hover:text-neutral-700">
                                {{ __('Log out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <main class="flex-1">
                <div class="py-6">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
