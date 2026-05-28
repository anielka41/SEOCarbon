<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-neutral-900">{{ __('Create Entry') }}</h1>
        <p class="mt-1 max-w-2xl text-sm text-neutral-600">{{ __('Dodaj nowy wpis katalogu i przypisz go do grupy oraz kategorii.') }}</p>
    </div>

    <form wire:submit.prevent="save" class="space-y-6 rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm">
        <div class="grid gap-6 md:grid-cols-2">
            <div class="space-y-2">
                <label class="text-sm font-medium text-neutral-700">{{ __('Category') }}</label>
                <select wire:model="categoryId" class="w-full rounded-xl border-neutral-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="">{{ __('Select category') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('categoryId') <p class="text-sm text-danger-600">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-neutral-700">{{ __('Group') }}</label>
                <select wire:model="packageId" class="w-full rounded-xl border-neutral-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="">{{ __('Select group') }}</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}@if($group->is_paid) - {{ number_format((float) $group->price_net_amount / 100, 2) }} {{ $group->currency }}@endif</option>
                    @endforeach
                </select>
                @error('packageId') <p class="text-sm text-danger-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div class="space-y-2">
                <label class="text-sm font-medium text-neutral-700">{{ __('Name') }}</label>
                <input wire:model.live="name" type="text" class="w-full rounded-xl border-neutral-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                @error('name') <p class="text-sm text-danger-600">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-neutral-700">{{ __('Slug') }}</label>
                <input wire:model.live="slug" type="text" class="w-full rounded-xl border-neutral-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                @error('slug') <p class="text-sm text-danger-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium text-neutral-700">{{ __('URL') }}</label>
            <input wire:model="url" type="url" class="w-full rounded-xl border-neutral-300 text-sm focus:border-primary-500 focus:ring-primary-500">
            @error('url') <p class="text-sm text-danger-600">{{ $message }}</p> @enderror
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium text-neutral-700">{{ __('Description') }}</label>
            <textarea wire:model="description" rows="8" class="w-full rounded-xl border-neutral-300 text-sm focus:border-primary-500 focus:ring-primary-500"></textarea>
            @error('description') <p class="text-sm text-danger-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('dashboard.entries.index') }}" class="inline-flex items-center justify-center rounded-xl border border-neutral-200 px-4 py-2 text-sm font-semibold text-neutral-700 transition hover:bg-neutral-50">
                {{ __('Cancel') }}
            </a>
            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-500">
                {{ __('Save Entry') }}
            </button>
        </div>
    </form>
</div>
