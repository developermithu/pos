<x-modal maxWidth="4xl" name="view-payments-{{ $sale->id }}">
    <div class="p-5 lg:p-6">
        <div class="flex items-center justify-between pb-5">
            <h2 class="text-xl font-semibold text-gray-500">All Payments</h2>

            <x-mary-button x-on:click="$dispatch('close')" icon="o-x-mark" class="btn-circle btn-ghost btn-sm" />
        </div>

        <div class="pb-5">
            @php
                $payments = $sale->payments;

                $headers = [
                    ['key' => 'id', 'label' => 'no'],
                    ['key' => 'reference', 'label' => 'Reference'],
                    ['key' => 'amount', 'label' => 'Amount'],
                    ['key' => 'payment_method', 'label' => 'Payment method'],
                    ['key' => 'account.name', 'label' => 'Account'], # <---- nested attributes
                    ['key' => 'created_at', 'label' => 'Date'],
                ];
            @endphp

            {{-- You can use any `$wire.METHOD` on `@row-click` --}}
            <x-mary-table :headers="$headers" :rows="$payments">
                @scope('cell_created_at', $payment)
                    {{ $payment->created_at->format('d M, Y') }}
                @endscope

                @scope('actions', $payment)
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
                                {{ __('Once you delete the payment you can not restore it. Still you want to delete it?') }}
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
                @endscope
            </x-mary-table>
        </div>
    </div>
</x-modal>
