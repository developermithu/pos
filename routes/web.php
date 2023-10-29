<?php

use App\Http\Controllers\LanguageSwitchController;
use App\Livewire\Customers\CreateCustomer;
use App\Livewire\Customers\EditCustomer;
use App\Livewire\Customers\ListCustomer;
use App\Livewire\Employees\CreateEmployee;
use App\Livewire\Employees\EditEmployee;
use App\Livewire\Employees\ListEmployee;
use App\Livewire\Salary\AddAdvancedSalary;
use App\Livewire\Salary\EditAdvancedSalary;
use App\Livewire\Salary\LastMonthSalary;
use App\Livewire\Salary\ListAdvancedSalary;
use App\Livewire\Salary\ListPaySalary;
use App\Livewire\Salary\PaySalaryNow;
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

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('admin.dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
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
});

Route::get('language-switch/{locale}', LanguageSwitchController::class)->name('setlocale');
