<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-neutral-900">{{ __('Welcome back') }}, {{ auth()->user()->name }}</h1>
            <p class="mt-1 text-sm text-neutral-600">{{ __('Panel użytkownika działa na froncie i korzysta z tych samych domenowych akcji co PA.') }}</p>
        </div>

        <a href="{{ route('dashboard.entries.create') }}" class="inline-flex items-center justify-center rounded-xl bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-500">
            {{ __('Add Entry') }}
        </a>
    </div>

    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-sm">
            <dt class="text-sm font-medium text-neutral-500">{{ __('Active Entries') }}</dt>
            <dd class="mt-2 text-3xl font-semibold tracking-tight text-neutral-900">{{ $activeEntriesCount }}</dd>
        </div>
        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-sm">
            <dt class="text-sm font-medium text-neutral-500">{{ __('Pending Entries') }}</dt>
            <dd class="mt-2 text-3xl font-semibold tracking-tight text-neutral-900">{{ $pendingEntriesCount }}</dd>
        </div>
        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-sm">
            <dt class="text-sm font-medium text-neutral-500">{{ __('Featured Entries') }}</dt>
            <dd class="mt-2 text-3xl font-semibold tracking-tight text-neutral-900">{{ $promotedEntriesCount }}</dd>
        </div>
    </div>

    <div class="rounded-2xl border border-neutral-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-neutral-100 px-5 py-4">
            <h2 class="text-sm font-semibold text-neutral-900">{{ __('Recent Entries') }}</h2>
            <a href="{{ route('dashboard.entries.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500">{{ __('View all') }}</a>
        </div>

        <div class="divide-y divide-neutral-100">
            @forelse($recentEntries as $entry)
                <div class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <h3 class="font-semibold text-neutral-900">{{ $entry->name }}</h3>
                            <span class="rounded-full bg-neutral-100 px-2 py-0.5 text-xs font-medium text-neutral-600">{{ $entry->status->getLabel() }}</span>
                        </div>
                        <p class="mt-1 text-sm text-neutral-500">{{ $entry->category?->name }}</p>
                    </div>

                    <a href="{{ route('dashboard.entries.edit', $entry) }}" class="text-sm font-semibold text-neutral-700 hover:text-primary-600">
                        {{ __('Edit') }}
                    </a>
                </div>
            @empty
                <div class="px-5 py-16 text-center">
                    <h3 class="text-sm font-semibold text-neutral-900">{{ __('No entries yet') }}</h3>
                    <p class="mt-1 text-sm text-neutral-500">{{ __('Create your first directory entry to get started.') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
