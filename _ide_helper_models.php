<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Account
 *
 * @property int $id
 * @property string $account_no
 * @property string $name
 * @property int $initial_balance
 * @property bool $is_active
 * @property string|null $details
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Expense> $expenses
 * @property-read int|null $expenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @method static \Illuminate\Database\Eloquent\Builder|Account active()
 * @method static \Illuminate\Database\Eloquent\Builder|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Account query()
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereAccountNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereInitialBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Account withoutTrashed()
 */
	class Account extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Attendance
 *
 * @property int $id
 * @property int $employee_id
 * @property \Illuminate\Support\Carbon $date
 * @property \App\Enums\AttendanceStatus $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Employee $employee
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance withoutTrashed()
 */
	class Attendance extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CashbookEntry
 *
 * @property int $id
 * @property int $store_id
 * @property int $account_id
 * @property int $amount
 * @property \App\Enums\CashbookEntryType $type
 * @property string|null $note
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Store $store
 * @method static \Illuminate\Database\Eloquent\Builder|CashbookEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashbookEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashbookEntry onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CashbookEntry query()
 * @method static \Illuminate\Database\Eloquent\Builder|CashbookEntry whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashbookEntry whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashbookEntry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashbookEntry whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashbookEntry whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashbookEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashbookEntry whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashbookEntry whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashbookEntry whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashbookEntry whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashbookEntry withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CashbookEntry withoutTrashed()
 */
	class CashbookEntry extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Category withoutTrashed()
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Customer
 *
 * @property int $id
 * @property string $name
 * @property string|null $company_name
 * @property string|null $address
 * @property string $phone_number
 * @property int $deposit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $deposits
 * @property-read int|null $deposits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Sale> $sales
 * @property-read int|null $sales_count
 * @method static \Database\Factories\CustomerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereDeposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer withoutTrashed()
 */
	class Customer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Employee
 *
 * @property int $id
 * @property string $name
 * @property string $father_name
 * @property string|null $address
 * @property string $phone_number
 * @property string $gender
 * @property int $basic_salary
 * @property int|null $old_basic_salary
 * @property \Illuminate\Support\Carbon|null $salary_updated_at
 * @property \Illuminate\Support\Carbon $joined_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $advancePayments
 * @property-read int|null $advance_payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendance> $attendances
 * @property-read int|null $attendances_count
 * @method static \Database\Factories\EmployeeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereBasicSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereFatherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereJoinedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereOldBasicSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereSalaryUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withoutTrashed()
 */
	class Employee extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Expense
 *
 * @property int $id
 * @property int $expense_category_id
 * @property string|null $details
 * @property int $amount
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\ExpenseCategory|null $expenseCategory
 * @property-read \App\Models\Payment|null $payment
 * @method static \Illuminate\Database\Eloquent\Builder|Expense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense query()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereExpenseCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense withoutTrashed()
 */
	class Expense extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExpenseCategory
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Expense> $expenses
 * @property-read int|null $expenses_count
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseCategory withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseCategory withoutTrashed()
 */
	class ExpenseCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MoneyTransfer
 *
 * @property int $id
 * @property int $from_account_id
 * @property int $to_account_id
 * @property int $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Account $fromAccount
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @property-read \App\Models\Account $toAccount
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyTransfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyTransfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyTransfer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyTransfer query()
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyTransfer whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyTransfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyTransfer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyTransfer whereFromAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyTransfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyTransfer whereToAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyTransfer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyTransfer withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyTransfer withoutTrashed()
 */
	class MoneyTransfer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int $account_id
 * @property int $amount
 * @property string|null $reference
 * @property string|null $note
 * @property \App\Enums\PaymentType $type
 * @property string $paymentable_type
 * @property int $paymentable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Account $account
 * @property-read \App\Models\Employee|null $employee
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $paymentable
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment withoutTrashed()
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property int|null $category_id
 * @property int $unit_id
 * @property int|null $purchase_unit_id
 * @property int|null $sale_unit_id
 * @property string $name
 * @property string $sku
 * @property int|null $qty
 * @property int $cost
 * @property int $price
 * @property int|null $purchase_price
 * @property int|null $sale_price
 * @property \App\Enums\ProductType $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Category|null $category
 * @property-read \App\Models\Unit $unit
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePurchasePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePurchaseUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSalePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSaleUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product withoutTrashed()
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Purchase
 *
 * @property int $id
 * @property int $supplier_id
 * @property string $invoice_no
 * @property int $subtotal
 * @property int|null $tax
 * @property int $total
 * @property int|null $paid_amount
 * @property \App\Enums\PurchaseStatus $status ordered
 * @property \App\Enums\PurchasePaymentStatus $payment_status paid
 * @property string|null $note
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PurchaseItem> $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @property-read \App\Models\Supplier $supplier
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase query()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereInvoiceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase withoutTrashed()
 */
	class Purchase extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PurchaseItem
 *
 * @property int $id
 * @property int $purchase_id
 * @property int $product_id
 * @property int $price
 * @property int $qty
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Purchase $purchase
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem wherePurchaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem withoutTrashed()
 */
	class PurchaseItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Sale
 *
 * @property int $id
 * @property int $customer_id
 * @property string $invoice_no
 * @property int $subtotal
 * @property int|null $tax
 * @property int $total
 * @property int|null $paid_amount
 * @property \App\Enums\SaleStatus $status ordered
 * @property \App\Enums\SalePaymentStatus $payment_status pending
 * @property string|null $note
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SaleItem> $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @method static \Illuminate\Database\Eloquent\Builder|Sale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereInvoiceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale withoutTrashed()
 */
	class Sale extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SaleItem
 *
 * @property int $id
 * @property int $sale_id
 * @property int $product_id
 * @property int $price
 * @property int $qty
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Sale $sale
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem whereSaleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SaleItem withoutTrashed()
 */
	class SaleItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Store
 *
 * @property int $id
 * @property string $name
 * @property string $location
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CashbookEntry> $cashbookEntries
 * @property-read int|null $cashbook_entries_count
 * @method static \Illuminate\Database\Eloquent\Builder|Store newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Store newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Store onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Store query()
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Store withoutTrashed()
 */
	class Store extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Supplier
 *
 * @property int $id
 * @property string $name
 * @property string|null $company_name
 * @property string|null $address
 * @property string $phone_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Purchase> $purchases
 * @property-read int|null $purchases_count
 * @method static \Database\Factories\SupplierFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier query()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier withoutTrashed()
 */
	class Supplier extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Unit
 *
 * @property int $id
 * @property int|null $unit_id
 * @property string $name
 * @property string $short_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Unit|null $baseUnit
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Unit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit query()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit withoutTrashed()
 */
	class Unit extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \App\Enums\UserRole $role
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

