<?php

namespace App\Traits;

use Livewire\Attributes\Url;

trait SearchAndFilter
{
    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'records')]
    public $filterByTrash;

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['filterByTrash', 'search'])) {
            $this->resetPage();
        }
    }

    public function clear()
    {
        $this->filterByTrash = '';
    }
}
