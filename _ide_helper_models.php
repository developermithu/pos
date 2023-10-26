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
 * App\Models\AdvancedSalary
 *
 * @property int $id
 * @property int $employee_id
 * @property string $month
 * @property string $year
 * @property int $amount
 * @property \Illuminate\Support\Carbon $paid_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AdvancedSalary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvancedSalary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvancedSalary query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvancedSalary whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvancedSalary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvancedSalary whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvancedSalary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvancedSalary whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvancedSalary wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvancedSalary whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvancedSalary whereYear($value)
 */
	class AdvancedSalary extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Customer
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $phone_number
 * @property int|null $due
 * @property int|null $advanced_paid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Database\Factories\CustomerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAdvancedPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereDue($value)
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
 * @property string $address
 * @property string $phone_number
 * @property int $salary
 * @property \Illuminate\Support\Carbon $joined_at
 * @property string $gender
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Database\Factories\EmployeeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereFatherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereJoinedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withoutTrashed()
 */
	class Employee extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Supplier
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $phone_number
 * @property string|null $bank_name
 * @property string|null $bank_branch
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Database\Factories\SupplierFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier query()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereBankBranch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereBankName($value)
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
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
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
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

