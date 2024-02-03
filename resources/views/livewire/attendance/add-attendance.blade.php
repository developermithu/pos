<div>
    <form wire:submit.prevent="markAttendance">
        <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1">
                <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                    <x-breadcrumb>
                        <x-breadcrumb.item label="attendance list" :href="route('admin.attendance.index')" />
                        <x-breadcrumb.item label="add" />
                    </x-breadcrumb>

                    <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                        {{ __('add attendance') }}
                    </h1>
                </div>

                <div class="items-center justify-end block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                    <div class="flex items-center gap-3 mb-4 sm:mb-0">
                        <label for="date" class="text-sm font-medium text-gray-700 capitalize dark:text-gray-300">
                            {{ __('select date') }}
                        </label>

                        <input type="date" wire:model="date" name="date" id="date"
                            class="px-4 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm bg-gray-50 sm:text-sm focus:ring-primary focus:border-primary dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary"
                            required>

                        @error('date')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>


        </div>

        <x-table>
            <x-slot name="heading">
                <x-table.heading> {{ __('no') }} </x-table.heading>
                <x-table.heading> {{ __('name') }} </x-table.heading>
                <x-table.heading> {{ __('status') }} </x-table.heading>
            </x-slot>

            @foreach ($employees as $employee)
                <x-table.row wire:key="{{ $employee->id }}" class="hover:bg-transparent dark:hover:bg-bg-transparent">
                    <x-table.cell> {{ $employee->id }} </x-table.cell>
                    <x-table.cell class="font-medium text-gray-800 dark:text-white"> {{ $employee->name }}
                    </x-table.cell>

                    <x-table.cell>
                        <div class="flex items-center gap-2">
                            <div class="flex items-center mr-4">
                                <input type="radio" name="attendanceStatus.{{ $employee->id }}"
                                    wire:model="attendanceStatus.{{ $employee->id }}" value="present"
                                    id="present_{{ $employee->id }}"
                                    class = "w-4 h-4 bg-gray-100 border-gray-300 text-primary focus:ring-primary dark:focus:ring-primary dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                    required>

                                <label for="present_{{ $employee->id }}"
                                    class="ml-2 text-sm font-medium text-gray-900 capitalize dark:text-gray-300">{{ __('present') }}</label>
                            </div>

                            <div class="flex items-center mr-4">
                                <input type="radio" name="attendanceStatus.{{ $employee->id }}"
                                    wire:model="attendanceStatus.{{ $employee->id }}" value="absent"
                                    id="absent_{{ $employee->id }}"
                                    class = "w-4 h-4 bg-gray-100 border-gray-300 text-primary focus:ring-primary dark:focus:ring-primary dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                    required>

                                <label for="absent_{{ $employee->id }}"
                                    class="ml-2 text-sm font-medium capitalize text-danger dark:text-gray-300">{{ __('absent') }}</label>
                            </div>
                        </div>

                        @error('attendanceStatus.' . $employee->id)
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </x-table.cell>
                </x-table.row>
            @endforeach

            <x-table.row class="hover:bg-transparent dark:hover:bg-bg-transparent">
                <x-table.cell colspan="3">
                    <x-button wire:loading.attr="disabled" wire:target="markAttendance" wire:loading.class="opacity-40">
                        {{ __('submit attendance') }}</x-button>
                </x-table.cell>
            </x-table.row>
        </x-table>
    </form>
</div>
