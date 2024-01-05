<x-modal maxWidth="{{ $size ?? 'xl' }}" align="top" name="add-payment">
    <!-- Modal header -->
    <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
        <h3 class="text-lg font-semibold text-gray-900 capitalize dark:text-white">
            {{ __('add new payment') }}
        </h3>

        <button type="button" x-on:click="$dispatch('close')"
            class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white">
            <x-mary-icon name="o-x-mark" />
            <span class="sr-only">Close modal</span>
        </button>
    </div>

    <!-- Modal body -->
    <form wire:submit="addPayment" class="p-4 md:p-5">
        <div class="grid grid-cols-2 gap-4 mb-5">
            <div class="col-span-2 sm:col-span-1">
                <x-input.group for="received_amount" label="{{ __('received amount') }}" :error="$errors->first('form.received_amount')">
                    <x-input wire:model="form.received_amount" id="received_amount" />
                </x-input.group>
            </div>

            <div class="col-span-2 sm:col-span-1">
                <x-input.group for="paid_amount" label="{{ __('paying amount *') }}" :error="$errors->first('form.paid_amount')">
                    <x-input wire:model="form.paid_amount" id="paid_amount" />
                </x-input.group>
            </div>

            <div class="col-span-2 sm:col-span-1">
                <x-input.group for="paid_by" label="{{ __('paid by *') }}" :error="$errors->first('form.paid_by')">
                    <x-input.select wire:model="form.paid_by">
                        <option value="cash">cash</option>
                        <option value="bank">bank</option>
                        <option value="cheque">cheque</option>
                        <option value="bkash">bkash</option>
                    </x-input.select>
                </x-input.group>
            </div>

            <div class="col-span-2 sm:col-span-1">
                <x-input.group for="account_id" label="{{ __('account name *') }}" :error="$errors->first('form.account_id')">
                    <x-input.select wire:model="form.account_id" :options="App\Models\Account::pluck('name', 'id')" />
                </x-input.group>
            </div>

            <div class="col-span-2">
                <x-input.group for="note" label="{{ __('note') }}" :error="$errors->first('form.note')">
                    <x-input.textarea wire:model="form.note" id="note" rows="3" />
                </x-input.group>
            </div>
        </div>

        <x-button wire:loading.attr="disabled" wire:loading.class="opacity-40" wire:target="addPayment"
            style="width: 100%; justify-content: center">
            {{ __('submit') }}
        </x-button>
    </form>
</x-modal>
