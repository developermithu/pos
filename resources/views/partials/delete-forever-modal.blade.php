<x-modal maxWidth="lg" name="confirm-deletion-forever-{{ $data->id }}">
    <div class="p-6 text-center whitespace-normal">
        <x-heroicon-o-exclamation-circle class="mx-auto mb-4 text-danger/30 dark:text-danger/50"
            style="width: 48px; height: 48px" />

        <h3 class="text-lg font-normal text-gray-500 dark:text-gray-400" style="text-transform: none">
            {{ __('Are you sure you want to delete this forever?') }}
        </h3>

        <p class="mb-5 text-gray-400" style="text-transform: none">
            {{ __('You can not restore again once you delete this') }}
        </p>

        <div class="space-x-3">
            <x-button type="danger" size="small" wire:click.prevent="forceDelete({{ $data->id }})"
                x-on:click="$dispatch('close')">
                {{ __('delete forever') }}
            </x-button>

            <x-button type="secondary" size="small" x-on:click="$dispatch('close')">
                {{ __('No, cancel') }}
            </x-button>
        </div>
    </div>
</x-modal>
