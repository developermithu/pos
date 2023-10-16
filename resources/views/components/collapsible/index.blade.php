<li {{ $attributes }}>
    {{ $trigger }}

    <ul x-cloak x-show="expanded" x-collapse.duration.300ms class="py-2 space-y-2">
        {{ $slot }}
    </ul>
</li>
