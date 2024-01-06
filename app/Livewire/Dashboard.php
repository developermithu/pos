<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard', [
            'totalProducts' => Product::count(),
            'totalEmployees' => Employee::count(),
            'totalSuppliers' => Supplier::count(),
            'totalCustomers' => Customer::count(),
            'totalUsers' => User::count(),
        ])->title(__('dashboard'));
    }
}
