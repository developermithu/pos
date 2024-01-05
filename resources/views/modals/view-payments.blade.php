<x-modal maxWidth="4xl" name="view-payments-{{ $sale->id }}">
    <div class="p-5 lg:p-6">
        <div class="pb-5 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-500">All Payments</h2>

            <x-mary-button x-on:click="$dispatch('close')" icon="o-x-mark" class="btn-circle btn-ghost btn-sm" />
        </div>

        <div class="pb-5">
            @php
                $payments = $sale->payments;

                $headers = [
                    ['key' => 'id', 'label' => 'no'],
                    ['key' => 'reference_no', 'label' => 'Reference'],
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

                {{-- Special `actions` slot --}}
                @scope('actions', $payment)
                    <div class="flex items-center gap-x-3">
                        <x-button flat="warning">
                            <x-heroicon-o-pencil-square /> {{ __('edit') }}
                        </x-button>

                        <x-button flat="danger"
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $payment->id }}')">
                            <x-heroicon-o-trash /> {{ __('delete') }}
                        </x-button>
                    </div>
                @endscope
            </x-mary-table>
        </div>
    </div>
</x-modal>
