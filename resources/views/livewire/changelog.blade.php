<div>
    <div class="p-5 pl-6 prose-sm prose prose-stone">
        {!! Str::markdown(file_get_contents(base_path('CHANGELOG.md'))) !!}
    </div>
</div>
