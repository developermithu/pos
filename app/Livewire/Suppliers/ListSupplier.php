<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListSupplier extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public $search = "";

    public function render()
    {
        $suppliers = Supplier::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('address', 'like', '%' . $this->search . '%')
            ->orWhere('phone_number', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(20);

        return view('livewire.suppliers.list-supplier', compact('suppliers'));
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return back();
    }
}
  
