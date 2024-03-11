<?php

use App\Http\Controllers\LanguageSwitchController;
use App\Livewire\Accounts\AllTransactions;
use App\Livewire\Accounts\CreateBalanceAdjustment;
use App\Livewire\Accounts\EditAccount;
use App\Livewire\Accounts\EditBalanceAdjustment;
use App\Livewire\Accounts\ListAccount;
use App\Livewire\Accounts\ListBalanceAdjustment;
use App\Livewire\Accounts\ListMoneyTransfer;
use App\Livewire\Attendance\AddAttendance;
use App\Livewire\Attendance\EditAttendance;
use App\Livewire\Attendance\LastMonthAttendance;
use App\Livewire\Attendance\ListAttendance;
use App\Livewire\Attendance\ShowAttendance;
use App\Livewire\Categories\EditCategory;
use App\Livewire\Categories\ListCategory;
use App\Livewire\Customers\CreateCustomer;
use App\Livewire\Customers\EditCustomer;
use App\Livewire\Customers\ListCustomer;
use App\Livewire\Customers\ShowCustomer;
use App\Livewire\Dashboard;
use App\Livewire\Employees\AddAdvancePayment;
use App\Livewire\Employees\CreateEmployee;
use App\Livewire\Employees\EditEmployee;
use App\Livewire\Employees\ListAdvancePayment;
use App\Livewire\Employees\ListEmployee;
use App\Livewire\Employees\ManageOvertime;
use App\Livewire\Employees\ShowEmployee;
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
use App\Livewire\Reports\CustomerDueReport;
use App\Livewire\Reports\SupplierDueReport;
use App\Livewire\Sales\AddSalePayment;
use App\Livewire\Sales\CreateSale;
use App\Livewire\Sales\ListSale;
use App\Livewire\Sales\ShowSale;
use App\Livewire\Suppliers\CreateSupplier;
use App\Livewire\Suppliers\EditSupplier;
use App\Livewire\Suppliers\ListSupplier;
use App\Livewire\Suppliers\ShowSupplier;
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

require __DIR__.'/auth.php';

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::group(['prefix' => 'suppliers', 'as' => 'suppliers.'], function () {
        Route::get('/', ListSupplier::class)->name('index');
        Route::get('/create', CreateSupplier::class)->name('create');
        Route::get('/{supplier}/edit', EditSupplier::class)->name('edit');
        Route::get('/{supplier:ulid}/show', ShowSupplier::class)->name('show');
    });

    Route::group(['prefix' => 'employees', 'as' => 'employees.'], function () {
        Route::get('/', ListEmployee::class)->name('index');
        Route::get('/create', CreateEmployee::class)->name('create');
        Route::get('/{employee}/edit', EditEmployee::class)->name('edit');
        Route::get('/{employee}/show', ShowEmployee::class)->name('show');
        Route::get('/list-advance-payment', ListAdvancePayment::class)->name('list.advance.payment');
        Route::get('/{employee}/add-advance-payment', AddAdvancePayment::class)->name('add-advance-payment');
        Route::get('/manage-overtime', ManageOvertime::class)->name('manage-overtime');
    });

    Route::group(['prefix' => 'customers', 'as' => 'customers.'], function () {
        Route::get('/', ListCustomer::class)->name('index');
        Route::get('/create', CreateCustomer::class)->name('create');
        Route::get('/{customer}/edit', EditCustomer::class)->name('edit');
        Route::get('/{customer:ulid}/show', ShowCustomer::class)->name('show');
    });

    Route::group(['prefix' => 'attendance', 'as' => 'attendance.'], function () {
        Route::get('/', ListAttendance::class)->name('index');
        Route::get('/add', AddAttendance::class)->name('add');
        Route::get('/{date}/edit', EditAttendance::class)->name('edit');
        Route::get('/show/{date}', ShowAttendance::class)->name('show');
        Route::get('/last-month', LastMonthAttendance::class)->name('last-month');
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
        Route::get('/{account:ulid}/edit', EditAccount::class)->name('edit');
        Route::get('/all-transactions', AllTransactions::class)->name('all-transactions');
        Route::get('/money-transfer', ListMoneyTransfer::class)->name('money-transfer');

        // Balance Adjustment
        Route::get('/balance-adjustment', ListBalanceAdjustment::class)->name('balance-adjustment');
        Route::get('/balance-adjustment/create', CreateBalanceAdjustment::class)->name('balance-adjustment.create');
        Route::get('/balance-adjustment/{balanceAdjustment}/edit', EditBalanceAdjustment::class)->name('balance-adjustment.edit');
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

    // Reports
    Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
        Route::get('/customer-due-report', CustomerDueReport::class)->name('customer-due-report');
        Route::get('/supplier-due-report', SupplierDueReport::class)->name('supplier-due-report');
    });
});

Route::get('language-switch/{locale}', LanguageSwitchController::class)->name('setlocale');
