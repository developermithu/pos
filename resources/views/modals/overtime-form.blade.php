<x-mary-drawer wire:model="showDrawer" :title="__($isEditing ? 'update overtime' : 'add overtime')" class="lg:w-3/12" with-close-button separator right>
    <form wire:submit="{{ $isEditing ? 'save' : 'create' }}">
        <div class="grid grid-cols-2 gap-4 mb-5">
            <div class="col-span-2">
                <x-input.group for="employee_id" label="{{ __('employee name *') }}" :error="$errors->first('form.employee_id')">
                    <x-input.select wire:model="form.employee_id" :options="App\Models\Employee::pluck('name', 'id')" id="employee_id" />
                </x-input.group>
            </div>

            <div class="col-span-2">
                <x-input.group for="hours_worked" label="working hours *" :error="$errors->first('form.hours_worked')">
                    <x-input wire:model="form.hours_worked" id="hours_worked" @input="calculateTotalAmount()" />
                </x-input.group>
            </div>

            <div class="col-span-2">
                <x-input.group for="rate_per_hour" label="rate per hour *" :error="$errors->first('form.rate_per_hour')">
                    <x-input type="number" wire:model="form.rate_per_hour" id="rate_per_hour"
                        @input="calculateTotalAmount()" />
                </x-input.group>
            </div>

            <div class="col-span-2">
                <x-input.group for="total_amount" label="total earning amount">
                    <x-input type="number" wire:model="form.total_amount" id="total_amount" disabled />
                </x-input.group>
            </div>

            <div class="col-span-2">
                <x-input.group for="date" label="date *" :error="$errors->first('form.date')">
                    <x-input type="date" wire:model="form.date" id="date" />
                </x-input.group>
            </div>
        </div>

        <x-button wire:loading.attr="disabled" wire:loading.class="opacity-40" wire:target="create,save"
            style="width: 100%; justify-content: center">
            {{ __('submit') }}
        </x-button>
    </form>
</x-mary-drawer>

<script>
    function calculateTotalAmount() {
        const hoursWorked = parseFloat(document.getElementById('hours_worked').value);
        const ratePerHour = parseFloat(document.getElementById('rate_per_hour').value);
        const totalAmount = Math.round(hoursWorked * ratePerHour); // Round to the nearest integer
        document.getElementById('total_amount').value = isNaN(totalAmount) ? '' : totalAmount;
    }
</script>
