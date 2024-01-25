<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Dashboard extends Component
{
    public array $monthlySalesChart;
    public array $top5CustomersChart;

    public function mount()
    {
        $this->getMonthlySalesData();
        $this->getTop5CustomersData();
    }

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


    // ============ Charts ========== //
    private function getMonthlySalesData()
    {
        $this->monthlySalesChart  = [
            'type' => 'bar',
            'data' => [
                'labels' => [],
                'datasets' => [
                    [
                        'label' => 'Monthly Sales',
                        'data' => [],
                        'backgroundColor' => [
                            'rgba(255, 99, 132, 0.95)',
                            'rgba(255, 159, 64, 0.95)',
                            'rgba(255, 205, 86, 0.95)',
                            'rgba(75, 192, 192, 0.95)',
                            'rgba(54, 162, 235, 0.95)',
                            'rgba(153, 102, 255, 0.95)',
                            'rgba(201, 203, 207, 0.95)'
                        ],
                    ]
                ]
            ]
        ];

        // Fetch current year monthly sales data from the database
        $monthlySales = Sale::selectRaw('DATE_FORMAT(date, "%M") as month, SUM(total) as total_sales')
            ->whereYear('date', now()->year)
            ->groupBy('month')
            ->pluck('total_sales', 'month');

        // Define months to ensure all months are present in the result
        $allMonths = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December',
        ];

        // Populate sales data for all months
        $salesData = [];
        foreach ($allMonths as $month) {
            $salesData[$month] = ($monthlySales[$month] ?? 0) / 100; // Apply the accessor
        }

        // Populate labels and datasets based on the sales data
        foreach ($salesData as $month => $sales) {
            $this->monthlySalesChart['data']['labels'][] = $month;
            $this->monthlySalesChart['data']['datasets'][0]['data'][] = $sales;
        }
    }

    private function getTop5CustomersData()
    {
        $currentYear = now()->year;

        $this->top5CustomersChart  = [
            'type' => 'pie',
            'data' => [
                'labels' => [],
                'datasets' => [
                    [
                        'label' => "Yearly Sales ($currentYear)",
                        'data' => [],
                    ]
                ]
            ]
        ];

        // Get the top 5 customers based on sales for the current year
        $topCustomers = Customer::select('customers.name', DB::raw('SUM(sales.total) as total_sales'))
            ->join('sales', 'customers.id', '=', 'sales.customer_id')
            ->whereYear('sales.date', $currentYear)
            ->groupBy('customers.id', 'customers.name')
            ->orderByDesc('total_sales')
            ->take(5)
            ->get();

        // Create an array containing customer names and their sales amounts
        $customerSales = [];
        foreach ($topCustomers as $customer) {
            $customerSales[$customer->name] = ($customer->total_sales ?? 0) / 100; // Apply the accessor
        }

        // Populate labels and datasets based on the sales data
        foreach ($customerSales as $name => $sales) {
            $this->top5CustomersChart['data']['labels'][] = $name;
            $this->top5CustomersChart['data']['datasets'][0]['data'][] = $sales;
        }
    }

    public function placeholder()
    {
        return view('livewire.placeholders.dashboard');
    }
}
