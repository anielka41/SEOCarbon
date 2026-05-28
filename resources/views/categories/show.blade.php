<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $category->name }} - Directory</title>
    <meta name="description" content="{{ $category->description }}">

    @if(isset($schema))
    <script type="application/ld+json">
        {!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-900 font-sans">
    <div class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <header class="mb-12">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 mb-4">{{ $category->name }}</h1>
            <p class="text-xl text-gray-500 max-w-3xl">{{ $category->description }}</p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2 space-y-6">
                @forelse($listings as $listing)
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex gap-6">
                    @if($listing->logo_path)
                    <img src="{{ asset('storage/' . $listing->logo_path) }}" alt="{{ $listing->name }}" class="h-20 w-20 object-contain rounded-lg border border-gray-100 p-1">
                    @else
                    <div class="h-20 w-20 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 font-bold text-2xl">
                        {{ substr($listing->name, 0, 1) }}
                    </div>
                    @endif

                    <div class="flex-1">
                        <h2 class="text-xl font-bold text-gray-900 mb-1">
                            <a href="{{ route('listings.show', $listing) }}" class="hover:text-primary-600 transition-colors">{{ $listing->name }}</a>
                        </h2>
                        <p class="text-gray-600 line-clamp-2 text-sm mb-4">{{ $listing->description }}</p>
                        <div class="flex items-center gap-4 text-xs text-gray-400">
                            <span>{{ $listing->address }}</span>
                            @if($listing->backlink_verified_at)
                            <span class="text-green-600 font-medium flex items-center gap-1">
                                <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg> Verified
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white p-12 rounded-xl border-2 border-dashed border-gray-200 text-center">
                    <p class="text-gray-500">No listings found in this category.</p>
                </div>
                @endforelse

                <div class="mt-8">
                    {{ $listings->links() }}
                </div>
            </div>

            <aside class="space-y-8">
                @if($category->faq && count($category->faq) > 0)
                <section class="bg-blue-600 text-white p-8 rounded-2xl shadow-xl">
                    <h3 class="text-lg font-bold mb-6">Frequently Asked Questions</h3>
                    <div class="space-y-6">
                        @foreach($category->faq as $item)
                        <div>
                            <h4 class="font-semibold mb-2">{{ $item['question'] }}</h4>
                            <p class="text-blue-100 text-sm leading-relaxed">{{ $item['answer'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif

                <div class="bg-white p-6 rounded-xl border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Promote your business</h3>
                    <p class="text-sm text-gray-500 mb-6">Want to appear at the top of the search results? Choose our premium package.</p>
                    <a href="{{ route('dashboard.entries.create') }}" class="block text-center bg-gray-900 text-white py-2.5 rounded-lg font-medium hover:bg-gray-800 transition-colors">Add your listing</a>
                </div>
            </aside>
        </div>
    </div>
</body>
</html>
