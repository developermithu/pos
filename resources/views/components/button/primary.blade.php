<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex gap-x-1.5 px-4 py-2 text-sm font-semibold tracking-widest text-white uppercase transition ease-in-out bg-primary border border-transparent rounded items-center hover:bg-primary/90 focus:bg-primary/90 active:bg-primary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
