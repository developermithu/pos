<x-modal maxWidth="2xl" name="view-account-transactions-{{ $data->ulid }}">
    <div class="p-5 lg:p-6">
        <div class="flex items-center justify-between pb-5">
            <h2 class="text-xl font-semibold text-gray-500">
                {{ $data->name }} - {{ __('transactions') }}
            </h2>

            <x-mary-button x-on:click="$dispatch('close')" icon="o-x-mark" class="btn-circle btn-ghost btn-sm" />
        </div>

        <div class="overflow-y-auto lg:max-h-[480px] max-h-[75vh] custom-scrollbar">
            @php
                $payments = $data->payments;

                $headers = [
                    ['key' => 'reference', 'label' => 'Reference'],
                    ['key' => 'amount', 'label' => 'Amount'],
                    ['key' => 'created_at', 'label' => 'Created'], //
                ];
            @endphp

            <x-mary-table :headers="$headers" :rows="$payments">
                @scope('cell_amount', $payment)
                    @if ($payment->type->isCredit())
                        <span class="text-success">
                            +{{ number_format($payment->amount) }} TK
                        </span>
                    @else
                        <span class="text-danger">
                            -{{ number_format($payment->amount) }} TK
                        </span>
                    @endif
                @endscope

                @scope('cell_created_at', $payment)
                    {{ $payment->created_at->format('d M, Y, g:i A') }}
                @endscope
            </x-mary-table>
        </div>
    </div>
</x-modal>
