<x-modal maxWidth="4xl" name="view-payments-{{ $data->id }}">
    <div class="p-5 lg:p-6">
        <div class="flex items-center justify-between pb-5">
            <h2 class="text-xl font-semibold text-gray-500">
                {{ __('all payments') }}
            </h2>

            <x-mary-button x-on:click="$dispatch('close')" icon="o-x-mark" class="btn-circle btn-ghost btn-sm" />
        </div>

        <div class="pb-5">
            @php
                $payments = $data->payments;

                $headers = [
                    ['key' => 'id', 'label' => 'No'],
                    ['key' => 'reference', 'label' => 'Reference'],
                    ['key' => 'amount', 'label' => 'Amount'],
                    ['key' => 'paid_by', 'label' => 'Paid by'],
                    ['key' => 'account.name', 'label' => 'Account'], // nested
                    ['key' => 'created_at', 'label' => 'Date'],
                ];
            @endphp

            {{-- You can use any `$wire.METHOD` on `@row-click` --}}
            <x-mary-table :headers="$headers" :rows="$payments">
                @scope('cell_created_at', $payment)
                    {{ $payment->created_at->format('d M, Y') }}
                @endscope

                @scope('actions', $payment)
                    @if ($payment->trashed())
                        <div class="flex items-center gap-x-3">
                            <x-button flat="primary" wire:click="restorePayment({{ $payment->id }})">
                                <x-heroicon-o-arrow-path /> {{ __('restore') }}
                            </x-button>

                            <x-button flat="danger"
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-payment-forever-{{ $payment->id }}')">
                                <x-heroicon-o-archive-box-x-mark /> {{ __('delete forever') }}
                            </x-button>
                        </div>

                        {{-- Force Delete Payment --}}
                        <x-modal maxWidth="lg" name="confirm-deletion-payment-forever-{{ $payment->id }}">
                            <div class="p-6 text-center whitespace-normal">
                                <x-heroicon-o-exclamation-circle class="mx-auto mb-4 text-danger/30 dark:text-danger/50"
                                    style="width: 48px; height: 48px" />

                                <h3 class="text-lg font-normal text-gray-500 dark:text-gray-400"
                                    style="text-transform: none">
                                    {{ __('Are you sure you want to delete this forever?') }}
                                </h3>

                                <p class="mb-5 text-gray-400" style="text-transform: none">
                                    {{ __('You can not restore again once you delete this') }}
                                </p>

                                <div class="space-x-3">
                                    <x-button type="danger" size="small"
                                        wire:click.prevent="forceDeletePayment({{ $payment->id }})"
                                        x-on:click="$dispatch('close')">
                                        {{ __('delete forever') }}
                                    </x-button>

                                    <x-button type="secondary" size="small" x-on:click="$dispatch('close')">
                                        {{ __('No, cancel') }}
                                    </x-button>
                                </div>
                            </div>
                        </x-modal>
                    @else
                        <div class="flex items-center gap-x-3">
                            <x-button flat="danger"
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-payment-{{ $payment->id }}')">
                                <x-heroicon-o-trash /> {{ __('delete') }}
                            </x-button>
                        </div>

                        {{-- Destroy Payment --}}
                        <x-modal maxWidth="md" name="confirm-deletion-payment-{{ $payment->id }}">
                            <div class="p-6 text-center whitespace-normal">
                                <x-heroicon-o-exclamation-circle class="mx-auto mb-4 text-gray-400 dark:text-gray-200"
                                    style="width: 48px; height: 48px" />

                                <h3 class="mb-5 text-lg font-normal text-center text-gray-500 dark:text-gray-400"
                                    style="text-transform: none">
                                    {{ __('Are you sure you want to delete this?') }}
                                </h3>

                                <div class="space-x-3">
                                    <x-button type="danger" size="small"
                                        wire:click.prevent="destroyPayment({{ $payment }})"
                                        x-on:click="$dispatch('close')">
                                        {{ __('Yes, delete') }}
                                    </x-button>

                                    <x-button type="secondary" size="small" x-on:click="$dispatch('close')">
                                        {{ __('No, cancel') }}
                                    </x-button>
                                </div>
                            </div>
                        </x-modal>
                    @endif
                @endscope
            </x-mary-table>
        </div>
    </div>
</x-modal>
