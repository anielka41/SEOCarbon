<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $listing->meta_title ?? $listing->name }} - {{ config('app.name') }}</title>
    <meta name="description" content="{{ $listing->meta_description ?? $listing->description }}">

    @if(isset($schema))
    <script type="application/ld+json">
        {!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-900 font-sans">
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <nav class="mb-8">
            <a href="/" class="text-primary-600 hover:text-primary-700 font-medium">&larr; Back to Directory</a>
        </nav>

        <article class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100">
            @if($listing->thumbnail_path)
            <img src="{{ asset('storage/' . $listing->thumbnail_path) }}" alt="{{ $listing->name }}" class="w-full h-64 object-cover">
            @endif

            <div class="p-8">
                <header class="flex items-start justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-2">{{ $listing->name }}</h1>
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            @if($listing->category)
                            <span class="bg-gray-100 px-2.5 py-0.5 rounded-full font-medium text-gray-700">{{ $listing->category->name }}</span>
                            @endif
                            <span>{{ $listing->address }}</span>
                        </div>
                    </div>

                    @if($listing->logo_path)
                    <img src="{{ asset('storage/' . $listing->logo_path) }}" alt="{{ $listing->name }} logo" class="h-16 w-16 object-contain rounded-lg border border-gray-100 p-1">
                    @endif
                </header>

                <div class="prose prose-blue max-w-none mb-10">
                    <p class="text-lg text-gray-600 leading-relaxed mb-6">{{ $listing->description }}</p>
                    {!! nl2br(e($listing->content)) !!}
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-gray-100 pt-8">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Contact Information</h3>
                        <dl class="space-y-3 text-sm">
                            @if($listing->contact_email)
                            <div class="flex gap-3">
                                <dt class="text-gray-400">Email:</dt>
                                <dd><a href="mailto:{{ $listing->contact_email }}" class="text-primary-600 hover:underline">{{ $listing->contact_email }}</a></dd>
                            </div>
                            @endif
                            @if($listing->contact_phone)
                            <div class="flex gap-3">
                                <dt class="text-gray-400">Phone:</dt>
                                <dd><a href="tel:{{ $listing->contact_phone }}" class="text-primary-600 hover:underline">{{ $listing->contact_phone }}</a></dd>
                            </div>
                            @endif
                            @if($listing->url)
                            <div class="flex gap-3">
                                <dt class="text-gray-400">Website:</dt>
                                <dd><a href="{{ $listing->url }}" target="_blank" rel="nofollow noopener" class="text-primary-600 hover:underline font-medium">{{ parse_url($listing->url, PHP_URL_HOST) }} &nearrow;</a></dd>
                            </div>
                            @endif
                        </dl>
                    </div>

                    @if($listing->tags->count() > 0)
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($listing->tags as $tag)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-blue-50 text-blue-700">
                                #{{ $tag->name }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </article>

        @if($listing->backlink_verified_at)
        <div class="mt-6 flex items-center justify-center gap-2 text-green-600 text-sm font-medium bg-green-50 py-2 rounded-lg border border-green-100">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Verified Backlink - This listing is prioritized
        </div>
        @endif
    </div>
</body>
</html>
