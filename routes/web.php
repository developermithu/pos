<?php

use App\Http\Controllers\LanguageSwitchController;
use App\Livewire\Accounts\AllTransactions;
use App\Livewire\Accounts\EditAccount;
use App\Livewire\Accounts\ListAccount;
use App\Livewire\Accounts\ListMoneyTransfer;
use App\Livewire\Attendance\AddAttendance;
use App\Livewire\Attendance\EditAttendance;
use App\Livewire\Attendance\ListAttendance;
use App\Livewire\Attendance\ShowAttendance;
use App\Livewire\Cashbooks\EditCashbookEntry;
use App\Livewire\Cashbooks\ListCashbookEntry;
use App\Livewire\Categories\EditCategory;
use App\Livewire\Categories\ListCategory;
use App\Livewire\Customers\AddDeposit;
use App\Livewire\Customers\CreateCustomer;
use App\Livewire\Customers\EditCustomer;
use App\Livewire\Customers\ListCustomer;
use App\Livewire\Dashboard;
use App\Livewire\Employees\CreateEmployee;
use App\Livewire\Employees\EditEmployee;
use App\Livewire\Employees\ListEmployee;
use App\Livewire\ExpenseCategories\EditExpenseCategory;
use App\Livewire\ExpenseCategories\ListExpenseCategory;
use App\Livewire\Expenses\CreateExpense;
use App\Livewire\Expenses\EditExpense;
use App\Livewire\Expenses\ListExpense;
use App\Livewire\Pos\CreateInvoice;
use App\Livewire\Pos\PosManagement;
use App\Livewire\Products\CreateProduct;
use App\Livewire\Products\EditProduct;
use App\Livewire\Products\ListProduct;
use App\Livewire\Purchases\AddPurchasePayment;
use App\Livewire\Purchases\CreatePurchase;
use App\Livewire\Purchases\GeneratePurchaseInvoice;
use App\Livewire\Purchases\ListPurchase;
use App\Livewire\Purchases\ShowPurchase;
use App\Livewire\Salary\AddAdvancedSalary;
use App\Livewire\Salary\EditAdvancedSalary;
use App\Livewire\Salary\LastMonthSalary;
use App\Livewire\Salary\ListAdvancedSalary;
use App\Livewire\Salary\ListPaySalary;
use App\Livewire\Salary\PaySalaryNow;
use App\Livewire\Sales\AddSalePayment;
use App\Livewire\Sales\CreateSale;
use App\Livewire\Sales\ListSale;
use App\Livewire\Sales\ShowSale;
use App\Livewire\Stores\EditStore;
use App\Livewire\Stores\ListStore;
use App\Livewire\Suppliers\CreateSupplier;
use App\Livewire\Suppliers\EditSupplier;
use App\Livewire\Suppliers\ListSupplier;
use App\Livewire\Units\EditUnit;
use App\Livewire\Units\ListUnit;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/admin/dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

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
        Route::get('/{customer}/add-deposit', AddDeposit::class)->name('add-deposit');
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
    });

    // Unit Management
    Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
        Route::get('/', ListCategory::class)->name('index');
        Route::get('/{category}/edit', EditCategory::class)->name('edit');
    });

    // Unit Management
    Route::group(['prefix' => 'units', 'as' => 'units.'], function () {
        Route::get('/', ListUnit::class)->name('index');
        Route::get('/{unit}/edit', EditUnit::class)->name('edit');
    });

    // Expense category management
    Route::group(['prefix' => 'expense/categories', 'as' => 'expense.category.'], function () {
        Route::get('/', ListExpenseCategory::class)->name('index');
        Route::get('/{expenseCategory}/edit', EditExpenseCategory::class)->name('edit');
    });

    // Expense management
    Route::group(['prefix' => 'expenses', 'as' => 'expenses.'], function () {
        Route::get('/', ListExpense::class)->name('index');
        Route::get('/create', CreateExpense::class)->name('create');
        Route::get('/{expense}/edit', EditExpense::class)->name('edit');
    });

    // Account management
    Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function () {
        Route::get('/', ListAccount::class)->name('index');
        Route::get('/{account}/edit', EditAccount::class)->name('edit');
        Route::get('/all-transactions', AllTransactions::class)->name('all-transactions');
        Route::get('/money-transfer', ListMoneyTransfer::class)->name('money-transfer');
    });

    // Store management
    Route::group(['prefix' => 'stores', 'as' => 'stores.'], function () {
        Route::get('/', ListStore::class)->name('index');
        Route::get('/{store}/edit', EditStore::class)->name('edit');
    });

    // Cashbook management
    Route::group(['prefix' => 'cashbooks', 'as' => 'cashbooks.'], function () {
        Route::get('/', ListCashbookEntry::class)->name('index');
        Route::get('/{cashbookEntry}/edit', EditCashbookEntry::class)->name('edit');
    });

    // Sale invoice
    Route::group(['prefix' => 'pos', 'as' => 'pos.'], function () {
        Route::get('/', PosManagement::class)->name('index');
        Route::get('/{invoice_no}/invoice', CreateInvoice::class)->name('create.invoice');
    });

    // Sales management
    Route::group(['prefix' => 'sales', 'as' => 'sales.'], function () {
        Route::get('/', ListSale::class)->name('index');
        Route::get('/create', CreateSale::class)->name('create');
        Route::get('/{sale}/show', ShowSale::class)->name('show');
        Route::get('/{sale}/add-payment', AddSalePayment::class)->name('add-payment');
    });

    // Purchase management
    Route::group(['prefix' => 'purchases', 'as' => 'purchases.'], function () {
        Route::get('/', ListPurchase::class)->name('index');
        Route::get('/create', CreatePurchase::class)->name('create');
        Route::get('/{purchase}/show', ShowPurchase::class)->name('show');
        Route::get('/{purchase}/add-payment', AddPurchasePayment::class)->name('add-payment');
        Route::get('/{invoice_no}/generate-invoice', GeneratePurchaseInvoice::class)->name('generate.invoice');
    });
});

Route::get('language-switch/{locale}', LanguageSwitchController::class)->name('setlocale');
