<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'SEOCarbon Dirs') }} - {{ __('Web & Company Directory') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="selection:bg-primary-500 selection:text-white">
        <!-- Header -->
        <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-neutral-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-bold text-neutral-900 tracking-tight">SEO<span class="text-primary-600 font-black italic">Carbon</span></span>
                    </div>

                    <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-neutral-600">
                        <a href="#" class="hover:text-primary-600 transition-colors">{{ __('Directory') }}</a>
                        <a href="#" class="hover:text-primary-600 transition-colors">{{ __('Blog') }}</a>
                        <a href="#" class="hover:text-primary-600 transition-colors">{{ __('Pricing') }}</a>
                    </nav>

                    <div class="flex items-center gap-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-neutral-900 hover:text-primary-600 transition-colors">
                                    {{ __('Dashboard') }}
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-semibold text-neutral-900 hover:text-primary-600 transition-colors">
                                    {{ __('Log in') }}
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-neutral-900 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-neutral-800 transition-all shadow-sm">
                                        {{ __('Add Entry') }}
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="relative py-20 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto">
                    <h1 class="text-5xl md:text-6xl font-extrabold text-neutral-900 tracking-tight mb-6">
                        {{ __('Discover the best companies and services') }}
                    </h1>
                    <p class="text-xl text-neutral-600 mb-10 leading-relaxed">
                        {{ __('Our directory connects you with thousands of verified businesses across all industries.') }}
                    </p>

                    <!-- Search Box -->
                    <div class="bg-white p-2 rounded-2xl shadow-xl border border-neutral-200 flex flex-col md:flex-row gap-2 max-w-2xl mx-auto">
                        <div class="flex-1 relative">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" placeholder="{{ __('What are you looking for?') }}" class="w-full pl-12 pr-4 py-3 bg-transparent border-none focus:ring-0 text-neutral-900 placeholder:text-neutral-400">
                        </div>
                        <button class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-xl font-bold transition-all shadow-md">
                            {{ __('Search') }}
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="py-20 bg-white/50 backdrop-blur-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-end mb-12">
                    <div>
                        <h2 class="text-3xl font-bold text-neutral-900 tracking-tight">{{ __('Browse Categories') }}</h2>
                        <p class="text-neutral-600 mt-2">{{ __('Find exactly what you need by industry.') }}</p>
                    </div>
                    <a href="#" class="text-primary-600 font-semibold hover:underline">{{ __('View all') }} &rarr;</a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                    @php
                        $categories = \App\Domain\Directory\Models\DirectoryCategory::where('type', 'directory')->where('is_active', true)->whereNull('parent_id')->limit(12)->get();
                    @endphp
                    @foreach($categories as $category)
                        <a href="{{ route('categories.show', $category) }}" class="group bg-white p-6 rounded-2xl border border-neutral-200 hover:border-primary-500 hover:shadow-lg transition-all text-center">
                            <div class="w-12 h-12 bg-neutral-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-50 transition-colors">
                                @if($category->icon)
                                    <span class="text-2xl">{{ $category->icon }}</span>
                                @else
                                    <svg class="w-6 h-6 text-neutral-400 group-hover:text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                    </svg>
                                @endif
                            </div>
                            <h3 class="font-bold text-neutral-900 group-hover:text-primary-600 transition-colors">{{ $category->name }}</h3>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Featured Entries -->
        <section class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-neutral-900 tracking-tight mb-12 text-center">{{ __('Featured Businesses') }}</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @php
                        $featured = \App\Domain\Directory\Models\DirectoryEntry::where('status', \App\Enums\EntryStatus::Published)->where('is_promoted', true)->limit(6)->get();
                    @endphp
                    @foreach($featured as $listing)
                        <div class="bg-white rounded-3xl border border-neutral-200 overflow-hidden hover:shadow-2xl transition-all group">
                            <div class="aspect-[4/3] bg-neutral-100 relative overflow-hidden">
                                @if($listing->thumbnail_path)
                                    <img src="{{ $listing->getThumbnailUrl() }}" alt="{{ $listing->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-neutral-300">
                                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-primary-600 shadow-sm">
                                    {{ $listing->category->name }}
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-neutral-900 mb-2 group-hover:text-primary-600 transition-colors">
                                    <a href="{{ route('listings.show', $listing) }}">{{ $listing->name }}</a>
                                </h3>
                                <p class="text-neutral-600 line-clamp-2 mb-4 text-sm">{{ $listing->description }}</p>
                                <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
                                    <div class="flex items-center gap-1">
                                        <span class="text-yellow-400">★★★★★</span>
                                        <span class="text-xs text-neutral-400 font-medium">(12 {{ __('reviews') }})</span>
                                    </div>
                                    <a href="{{ route('listings.show', $listing) }}" class="text-sm font-bold text-neutral-900 hover:text-primary-600 transition-colors">
                                        {{ __('View Details') }} &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-neutral-900 text-white py-20 mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                    <div class="col-span-1 md:col-span-2">
                        <span class="text-3xl font-bold tracking-tight">SEO<span class="text-primary-500 italic font-black">Carbon</span></span>
                        <p class="mt-6 text-neutral-400 max-w-sm leading-relaxed">
                            {{ __('The most advanced web and company directory platform. Built for performance, security, and scalability.') }}
                        </p>
                    </div>
                    <div>
                        <h4 class="font-bold mb-6 text-lg">{{ __('Quick Links') }}</h4>
                        <ul class="space-y-4 text-neutral-400 text-sm font-medium">
                            <li><a href="#" class="hover:text-white transition-colors">{{ __('Browse Directory') }}</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">{{ __('Blog Posts') }}</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">{{ __('Pricing Plans') }}</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">{{ __('Terms of Service') }}</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold mb-6 text-lg">{{ __('Follow Us') }}</h4>
                        <div class="flex gap-4">
                            <!-- Social Icons -->
                        </div>
                    </div>
                </div>
                <div class="border-t border-neutral-800 mt-20 pt-8 text-center text-neutral-500 text-sm font-medium">
                    &copy; {{ date('Y') }} SEO<span class="text-primary-500">Carbon</span> Dirs. {{ __('All rights reserved.') }}
                </div>
            </div>
        </footer>
    </body>
</html>
