<div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
    <div class="flex flex-col mb-4 col-span-full md:flex-row md:items-center md:justify-between xl:mb-2">
        <x-breadcrumb>
            <x-breadcrumb.item :label="__('expenses')" :href="route('admin.expenses.index')" />
            <x-breadcrumb.item :label="__('edit')" />
        </x-breadcrumb>

        <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
            {{ __('update expense') }}
        </h1>
    </div>

    <x-status :status="session('status')" class="w-full m-auto lg:max-w-3xl col-span-full" />

    <div class="w-full m-auto lg:max-w-3xl col-span-full">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <form wire:submit="save">
                <div class="grid grid-cols-6 gap-6">
                    <x-input.group for="expense_category_id" label="{{ __('expense category *') }}" :error="$errors->first('form.expense_category_id')">
                        <x-input.select wire:model="form.expense_category_id" required>
                            <option value="" disabled>-- select expense category --</option>
                            @foreach (App\Models\ExpenseCategory::pluck('name', 'id') as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>

                    <x-input.group for="account_id" label="{{ __('account *') }}" :error="$errors->first('form.account_id')">
                        <x-input.select wire:model="form.account_id" :options="$accounts" required />
                    </x-input.group>

                    <x-input.group for="amount" label="{{ __('amount *') }}" :error="$errors->first('form.amount')"
                        class="sm:col-span-full">
                        <x-input type="number" wire:model="form.amount" id="amount" required />
                    </x-input.group>

                    <x-input.group for="details" label="{{ __('details') }}" :error="$errors->first('form.details')"
                        class="sm:col-span-full">
                        <x-input.textarea wire:model="form.details" id="details"></x-input.textarea>
                    </x-input.group>

                    <div class="col-span-6 sm:col-full">
                        <x-button.primary wire:loading.attr="disabled" wire:target="save"
                            wire:loading.class="opacity-40">
                            {{ __('save') }}
                        </x-button.primary>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
