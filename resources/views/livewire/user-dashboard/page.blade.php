<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-neutral-900">{{ $heading }}</h1>
            <p class="mt-1 max-w-2xl text-sm text-neutral-600">{{ $description }}</p>
        </div>

        @if(! empty($primaryActionRoute))
            <a href="{{ route($primaryActionRoute) }}" class="inline-flex items-center justify-center rounded-xl bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-500">
                {{ $primaryActionLabel }}
            </a>
        @endif
    </div>

    <div class="rounded-2xl border border-dashed border-neutral-200 bg-white p-8">
        <p class="text-sm text-neutral-600">
            {{ __('This section is available in the frontend dashboard and uses shared domain actions.') }}
        </p>
    </div>
</div>
