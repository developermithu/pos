<x-modal maxWidth="md" name="confirm-deletion-{{ $data->id }}">
    <div class="p-6 text-center whitespace-normal">
        <x-heroicon-o-exclamation-circle class="mx-auto mb-4 text-gray-400 dark:text-gray-200"
            style="width: 48px; height: 48px" />

        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400" style="text-transform: none">
            {{ __('Are you sure you want to delete this?') }}
        </h3>

        <div class="space-x-3">
            <x-button type="danger" size="small" wire:click.prevent="destroy({{ $data }})"
                x-on:click="$dispatch('close')">
                {{ __('Yes, delete') }}
            </x-button>

            <x-button type="secondary" size="small" x-on:click="$dispatch('close')">
                {{ __('No, cancel') }}
            </x-button>
        </div>
    </div>
</x-modal>
