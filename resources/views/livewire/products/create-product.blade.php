<div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
    <div class="flex flex-col mb-4 col-span-full md:flex-row md:items-center md:justify-between xl:mb-2">
        {{-- Breadcrumb --}}
        <x-breadcrumb>
            <x-breadcrumb.item label="products" :href="route('admin.products.index')" />
            <x-breadcrumb.item label="create" />
        </x-breadcrumb>

        <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
            {{ __('add new product') }}
        </h1>
    </div>

    <div class="col-span-full">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <form wire:submit="save">
                <div class="grid grid-cols-6 gap-6">
                    <x-input.group label="product type *" :error="$errors->first('type')" class="lg:col-span-2">
                        <x-input.select wire:model="type">
                            <option value="" disabled>-- {{ __('choose product type') }} --</option>
                            @foreach (App\Enums\ProductType::forSelect() as $value => $name)
                                <option value="{{ $value }}"> {{ $name }} </option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>

                    <x-input.group for="name" label="name *" :error="$errors->first('name')" class="lg:col-span-2">
                        <x-input wire:model="name" id="name" />
                    </x-input.group>

                    <x-input.group for="category_id" label="category name" :error="$errors->first('category_id')" class="lg:col-span-2">
                        <x-input.select wire:model="category_id" :options="App\Models\Category::pluck('name', 'id')" selected="true" />
                    </x-input.group>

                    <x-input.group label="unit name *" :error="$errors->first('unit_id')" class="lg:col-span-2">
                        <x-input.select wire:model.change="unit_id" class="!lowercase" :options="$baseUnits" selected="true"
                            placeholder="choose unit" />
                    </x-input.group>

                    <x-input.group label="sale unit" :error="$errors->first('sale_unit_id')" class="lg:col-span-2">
                        <x-input.select wire:model="sale_unit_id" class="!lowercase">
                            <option value="" selected>-- {{ __('choose sale unit') }} --</option>
                            @if (!is_null($sale_units))
                                @foreach ($sale_units as $key => $name)
                                    <option value="{{ $key }}"> {{ $name }} </option>
                                @endforeach
                            @endif
                        </x-input.select>
                    </x-input.group>

                    <x-input.group label="purchase unit" :error="$errors->first('purchase_unit_id')" class="lg:col-span-2">
                        <x-input.select wire:model="purchase_unit_id" class="!lowercase">
                            <option value="" selected>-- {{ __('choose purchase unit') }} --</option>
                            @if (!is_null($purchase_units))
                                @foreach ($purchase_units as $key => $name)
                                    <option value="{{ $key }}"> {{ $name }} </option>
                                @endforeach
                            @endif
                        </x-input.select>
                    </x-input.group>

                    <x-input.group for="qty" label="quantity" :error="$errors->first('qty')" class="lg:col-span-2">
                        <x-input type="number" wire:model="qty" id="qty" placeholder="0" />
                    </x-input.group>

                    <x-input.group for="cost" label="cost (per unit) *" :error="$errors->first('cost')" class="lg:col-span-2">
                        <x-input type="number" wire:model="cost" id="cost" placeholder="00" />
                    </x-input.group>

                    <x-input.group for="price" label="price (per unit) *" :error="$errors->first('price')" class="lg:col-span-2">
                        <x-input type="number" wire:model="price" id="price" placeholder="00" />
                    </x-input.group>

                    <div class="col-span-6 sm:col-full">
                        <x-button.primary wire:loading.attr="disabled" wire:target="save"
                            wire:loading.class="opacity-40">
                            {{ __('submit') }}
                        </x-button.primary>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
