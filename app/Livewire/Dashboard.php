<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\User;
use DateTimeInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy]
#[Title('dashboard')]
class Dashboard extends Component
{
    public array $monthlySalesChart;
    public array $top5CustomersChart;
    private ?DateTimeInterface $cacheDuration;

    public function mount()
    {
        $this->cacheDuration = now()->addHours(1);
        $this->getMonthlySalesData();
        $this->getTop5CustomersData();
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'totalProducts' => $this->getTotalProducts(),
            'totalEmployees' => $this->getTotalEmployees(),
            'totalSuppliers' => $this->getTotalSuppliers(),
            'totalCustomers' => $this->getTotalCustomers(),
            'totalUsers' => $this->getTotalUsers(),
            'totalSales' => $this->getTotalSales(),
            'totalPurchases' => $this->getTotalPurchases(),
            'totalExpenses' => $this->getTotalExpenses(),
            'totalCustomerDue' => $this->getTotalCustomerDue(),
            'totalSupplierDue' => $this->getTotalSupplierDue(),
        ]);
    }

    // ============ Charts ========== //
    private function getMonthlySalesData()
    {
        $this->monthlySalesChart = [
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
                            'rgba(201, 203, 207, 0.95)',
                        ],
                    ],
                ],
            ],
        ];

        // Fetch current year monthly sales data from the database
        $monthlySales = $this->getMonthlySales();

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

        $this->top5CustomersChart = [
            'type' => 'pie',
            'data' => [
                'labels' => [],
                'datasets' => [
                    [
                        'label' => "Yearly Sales ($currentYear)",
                        'data' => [],
                    ],
                ],
            ],
        ];

        // Get the top 5 customers based on sales for the current year
        $topCustomers = $this->getTop5Customer();

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
    // ============ Charts ========== //

    /**
     * Get monthly sales.
     *
     * @return array<string, int>
     */
    private function getMonthlySales()
    {
        return Cache::remember('monthlySales', $this->cacheDuration, function () {
            return Sale::selectRaw('DATE_FORMAT(date, "%M") as month, SUM(total) as total_sales')
                ->whereYear('date', now()->year)
                ->groupBy('month')
                ->pluck('total_sales', 'month');
        });
    }

    /**
     * Get top 5 customers based on total sales.
     *
     * @return Collection<Customer>
     */
    private function getTop5Customer()
    {
        return Cache::remember('top5Customer', $this->cacheDuration, function () {
            return Customer::select('customers.name', DB::raw('SUM(sales.total) as total_sales'))
                ->join('sales', 'customers.id', '=', 'sales.customer_id')
                ->whereYear('sales.date', now()->year)
                ->groupBy('customers.id', 'customers.name')
                ->orderByDesc('total_sales')
                ->take(5)
                ->get();
        });
    }

    private function getTotalProducts(): int
    {
        return Cache::remember('totalProducts', $this->cacheDuration, function () {
            return Product::count();
        });
    }

    private function getTotalEmployees(): int
    {
        return Cache::remember('totalEmployees', $this->cacheDuration, function () {
            return Employee::count();
        });
    }

    private function getTotalSuppliers(): int
    {
        return Cache::remember('totalSuppliers', $this->cacheDuration, function () {
            return Supplier::count();
        });
    }

    private function getTotalCustomers(): int
    {
        return Cache::remember('totalCustomers', $this->cacheDuration, function () {
            return Customer::count();
        });
    }

    private function getTotalUsers(): int
    {
        return Cache::remember('totalUsers', $this->cacheDuration, function () {
            return User::count();
        });
    }

    private function getTotalSales(): int
    {
        return Cache::remember('totalSales', $this->cacheDuration, function () {
            return Sale::sum('total') / 100;
        });
    }

    private function getTotalPurchases(): int
    {
        return Cache::remember('totalPurchases', $this->cacheDuration, function () {
            return Purchase::sum('total') / 100;
        });
    }

    private function getTotalExpenses(): int
    {
        return Cache::remember('totalExpenses', $this->cacheDuration, function () {
            return Expense::sum('amount') / 100;
        });
    }

    private function getTotalCustomerDue(): int
    {
        return Cache::remember('totalCustomerDue', $this->cacheDuration, function () {
            return Customer::query()
                ->selectRaw('SUM(sales.total / 100) - SUM(sales.paid_amount) as total_due')
                ->leftJoin('sales', 'customers.id', '=', 'sales.customer_id')
                ->whereNull('sales.deleted_at')
                ->get()
                ->sum('total_due');
        });
    }

    private function getTotalSupplierDue(): int
    {
        return Cache::remember('totalSupplierDue', $this->cacheDuration, function () {
            return Supplier::query()
                ->selectRaw('SUM(purchases.total / 100) - SUM(purchases.paid_amount) as total_due')
                ->leftJoin('purchases', 'suppliers.id', '=', 'purchases.supplier_id')
                ->whereNull('purchases.deleted_at')
                ->get()
                ->sum('total_due');
        });
    }

    public function placeholder()
    {
        return view('livewire.placeholders.dashboard-page');
    }
}
