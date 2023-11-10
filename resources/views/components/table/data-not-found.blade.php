@props(['colspan'])

<tr>
    <td colspan="{{ $colspan }}">
        <div
            class="py-10 text-xl font-bold text-center text-gray-500 lg:text-3xl dark:text-gray-300 flex flex-col items-center gap-2">
            <x-heroicon-o-x-circle class="w-8 h-8 text-gray-400" />
            {{ __('data not found') }}
        </div>
    </td>
</tr>
