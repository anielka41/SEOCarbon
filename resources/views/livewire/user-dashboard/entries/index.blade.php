<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-neutral-900">{{ __('My Entries') }}</h1>
            <p class="mt-1 max-w-2xl text-sm text-neutral-600">{{ __('Przeglądaj swoje wpisy i przechodź do edycji lub tworzenia nowych.') }}</p>
        </div>

        <a href="{{ route('dashboard.entries.create') }}" class="inline-flex items-center justify-center rounded-xl bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-500">
            {{ __('Add Entry') }}
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-neutral-200 bg-white shadow-sm">
        @forelse($entries as $entry)
            <div class="flex flex-col gap-4 border-b border-neutral-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <h2 class="text-base font-semibold text-neutral-900">{{ $entry->name }}</h2>
                        <span class="rounded-full bg-neutral-100 px-2 py-0.5 text-xs font-medium text-neutral-600">{{ $entry->status->getLabel() }}</span>
                        @if($entry->is_promoted)
                            <span class="rounded-full bg-amber-100 px-2 py-0.5 text-xs font-medium text-amber-700">{{ __('Featured') }}</span>
                        @endif
                    </div>
                    <p class="mt-1 text-sm text-neutral-500">{{ $entry->category?->name }}</p>
                    <p class="mt-1 truncate text-sm text-neutral-500">{{ $entry->url }}</p>
                </div>

                <a href="{{ route('dashboard.entries.edit', $entry) }}" class="inline-flex items-center justify-center rounded-xl border border-neutral-200 px-4 py-2 text-sm font-semibold text-neutral-700 transition hover:bg-neutral-50">
                    {{ __('Edit') }}
                </a>
            </div>
        @empty
            <div class="px-6 py-16 text-center">
                <h2 class="text-lg font-semibold text-neutral-900">{{ __('No entries yet') }}</h2>
                <p class="mt-2 text-sm text-neutral-600">{{ __('Create your first directory entry to start managing it from the dashboard.') }}</p>
                <div class="mt-6">
                    <a href="{{ route('dashboard.entries.create') }}" class="inline-flex items-center justify-center rounded-xl bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-500">
                        {{ __('Create Entry') }}
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <div class="px-1">
        {{ $entries->links() }}
    </div>
</div>
