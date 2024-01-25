<x-modal maxWidth="3xl" name="view-advance-payments-{{ $data->id }}">
    <div class="p-5 lg:p-6">
        <div class="flex items-center justify-between pb-5">
            <h2 class="text-xl font-semibold text-gray-500">
                {{ __('all advance payments') }}
            </h2>

            <x-mary-button x-on:click="$dispatch('close')" icon="o-x-mark" class="btn-circle btn-ghost btn-sm" />
        </div>

        <div class="pb-5">
            @php
                $advancePayments = $data->advancePayments;

                $headers = [
                    ['key' => 'id', 'label' => 'no'],
                    ['key' => 'amount', 'label' => 'Amount'],
                    ['key' => 'account.name', 'label' => 'Account'], // nested
                    ['key' => 'created_at', 'label' => 'Date'],
                ];
            @endphp

            <x-mary-table :headers="$headers" :rows="$advancePayments">
                @scope('cell_created_at', $advancePayment)
                    {{ $advancePayment->created_at->format('d M, Y') }}
                @endscope

                @scope('actions', $advancePayment)
                    @if ($advancePayment->trashed())
                        <div class="flex items-center gap-x-3">
                            <x-button flat="primary" wire:click="restoreAdvancePayment({{ $advancePayment->id }})">
                                <x-heroicon-o-arrow-path /> {{ __('restore') }}
                            </x-button>

                            <x-button flat="danger" wire:click="forceDeleteAdvancePayment({{ $advancePayment->id }})"
                                wire:confirm="{{ __('Are you sure you want to delete this forever?') }}">
                                <x-heroicon-o-archive-box-x-mark /> {{ __('delete forever') }}
                            </x-button>
                        </div>
                    @else
                        <div class="flex items-center gap-x-3">
                            <x-button flat="danger" wire:click="destroyAdvancePayment({{ $advancePayment->id }})"
                                wire:confirm="{{ __('Are you sure you want to delete this?') }}">
                                <x-heroicon-o-trash /> {{ __('delete') }}
                            </x-button>
                        </div>
                    @endif
                @endscope
            </x-mary-table>
        </div>
    </div>
</x-modal>
