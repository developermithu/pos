<?php

use App\Http\Controllers\LanguageSwitchController;
use App\Livewire\Attendance\AddAttendance;
use App\Livewire\Attendance\EditAttendance;
use App\Livewire\Attendance\ListAttendance;
use App\Livewire\Attendance\ShowAttendance;
use App\Livewire\Customers\CreateCustomer;
use App\Livewire\Customers\EditCustomer;
use App\Livewire\Customers\ListCustomer;
use App\Livewire\Employees\CreateEmployee;
use App\Livewire\Employees\EditEmployee;
use App\Livewire\Employees\ListEmployee;
use App\Livewire\Expenses\CreateExpense;
use App\Livewire\Expenses\EditExpense;
use App\Livewire\Expenses\MonthlyExpenses;
use App\Livewire\Expenses\TodaysExpenses;
use App\Livewire\Expenses\YearlyExpenses;
use App\Livewire\Pos\CreateInvoice;
use App\Livewire\Pos\PosManagement;
use App\Livewire\Products\CreateProduct;
use App\Livewire\Products\EditProduct;
use App\Livewire\Products\ListProduct;
use App\Livewire\Products\ShowProduct;
use App\Livewire\Salary\AddAdvancedSalary;
use App\Livewire\Salary\EditAdvancedSalary;
use App\Livewire\Salary\LastMonthSalary;
use App\Livewire\Salary\ListAdvancedSalary;
use App\Livewire\Salary\ListPaySalary;
use App\Livewire\Salary\PaySalaryNow;
use App\Livewire\Sales\ListSale;
use App\Livewire\Sales\ShowSale;
use App\Livewire\Suppliers\CreateSupplier;
use App\Livewire\Suppliers\EditSupplier;
use App\Livewire\Suppliers\ListSupplier;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', 'dashboard');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('admin.dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'verified']], function () {
    Route::group(['prefix' => 'suppliers', 'as' => 'suppliers.'], function () {
        Route::get('/', ListSupplier::class)->name('index');
        Route::get('/create', CreateSupplier::class)->name('create');
        Route::get('/{supplier}/edit', EditSupplier::class)->name('edit');
    });

    Route::group(['prefix' => 'employees', 'as' => 'employees.'], function () {
        Route::get('/', ListEmployee::class)->name('index');
        Route::get('/create', CreateEmployee::class)->name('create');
        Route::get('/{employee}/edit', EditEmployee::class)->name('edit');
    });

    Route::group(['prefix' => 'customers', 'as' => 'customers.'], function () {
        Route::get('/', ListCustomer::class)->name('index');
        Route::get('/create', CreateCustomer::class)->name('create');
        Route::get('/{customer}/edit', EditCustomer::class)->name('edit');
    });

    Route::group(['prefix' => 'advanced-salary', 'as' => 'advanced.salary.'], function () {
        Route::get('/', ListAdvancedSalary::class)->name('index');
        Route::get('/add', AddAdvancedSalary::class)->name('add');
        Route::get('/{advanced_salary}/edit', EditAdvancedSalary::class)->name('edit');
    });

    Route::group(['prefix' => 'pay-salary', 'as' => 'pay.salary.'], function () {
        Route::get('/', ListPaySalary::class)->name('index');
        Route::get('/{id}/now', PaySalaryNow::class)->name('now');
    });

    Route::get('/last-month-salary', LastMonthSalary::class)->name('last.month.salary');

    Route::group(['prefix' => 'attendance', 'as' => 'attendance.'], function () {
        Route::get('/', ListAttendance::class)->name('index');
        Route::get('/add', AddAttendance::class)->name('add');
        Route::get('/{date}/edit', EditAttendance::class)->name('edit');
        Route::get('/show/{date}', ShowAttendance::class)->name('show');
    });

    // Product Management
    Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
        Route::get('/', ListProduct::class)->name('index');
        Route::get('/create', CreateProduct::class)->name('create');
        Route::get('/{product}/edit', EditProduct::class)->name('edit');
        Route::get('/{product}/show', ShowProduct::class)->name('show');
    });

    // Inventory Expense management
    Route::group(['prefix' => 'expenses', 'as' => 'expenses.'], function () {
        Route::get('/create', CreateExpense::class)->name('create');
        Route::get('/{expense}/edit', EditExpense::class)->name('edit');
        Route::get('/todays', TodaysExpenses::class)->name('todays');
        Route::get('/monthly', MonthlyExpenses::class)->name('monthly');
        Route::get('/yearly', YearlyExpenses::class)->name('yearly');
    });

    // Inventory Expense management
    Route::group(['prefix' => 'pos', 'as' => 'pos.'], function () {
        Route::get('/', PosManagement::class)->name('index');
        Route::get('/create-invoice', CreateInvoice::class)->name('create.invoice');
    });

    // Sales management
    Route::group(['prefix' => 'sales', 'as' => 'sales.'], function () {
        Route::get('/', ListSale::class)->name('index');
        Route::get('/{sale}/show', ShowSale::class)->name('show');
    });
});

Route::get('language-switch/{locale}', LanguageSwitchController::class)->name('setlocale');
