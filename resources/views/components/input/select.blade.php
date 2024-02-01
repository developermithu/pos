@props(['options' => null, 'placeholder' => null, 'selected' => false])

<select
    {{ $attributes->merge([
        'class' =>
            'shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-primary focus:border-primary block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary capitalize',
    ]) }}>

    @if ($options)
        <option value="" {{ $selected ? 'selected' : 'disabled' }}>-- {{ __($placeholder ?? 'choose option') }} --
        </option>

        @foreach ($options as $key => $name)
            <option value="{{ $key }}"> {{ $name }} </option>
        @endforeach
    @else
        {{ $slot }}
    @endif

</select>
