<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/mailable', function () {
    $tenant = App\Models\Tenant::find(1);

    return new App\Mail\TenantAccountCreated($tenant);
});

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/tenants/password/{inviteUuid}/create', [TenantController::class, 'createPassword'])->name('tenants.password.create');
Route::post('/tenants/password/{inviteUuid}', [TenantController::class, 'storePassword'])->name('tenants.password.store');

Route::post('mpesa/stk/callback', [PaymentController::class, 'stkCallback']);

Auth::routes([
    'verify' => true,
]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('users', UserController::class)->parameters([
        'users' => 'userUuid',
    ])->only('edit', 'update');

    Route::prefix('setup/')->group(function () {
        Route::resource('roles', RoleController::class)->parameters([
            'roles' => 'roleUuid',
        ]);

        Route::get('/roles/{roleUuid}/delete', [RoleController::class, 'delete'])->name('roles.delete');
    });

    Route::resource('rentals', RentalController::class)->parameters([
        'rentals' => 'rentalUuid',
    ]);

    Route::get('/rentals/{rentalUuid}/delete', [RentalController::class, 'delete'])->name('rentals.delete');

    Route::resource('rentals.houses', HouseController::class)->parameters([
        'rentals' => 'rentalUuid',
        'houses' => 'houseUuid',
    ])->except(['index']);

    Route::controller(HouseController::class)->group(function () {
        Route::get('/rentals/{rentalUuid}/houses/{houseUuid}/delete', 'delete')->name('rentals.houses.delete');
        Route::get('/rentals/{rentalUuid}/houses/{houseUuid}/vacate', 'vacate')->name('rentals.houses.vacate');
        Route::post('/rentals/{rentalUuid}/houses/{houseUuid}/vacate', 'vacateStore')->name('rentals.houses.vacateStore');
    });

    Route::resource('rentals.invoiceItems', InvoiceItemController::class)->parameters([
        'rentals' => 'rentalUuid',
        'invoiceItems' => 'invoiceItemUuid',
    ]);

    Route::get('/rentals/{rentalUuid}/invoiceItems/{invoiceItemUuid}/delete', [InvoiceItemController::class, 'delete'])->name('rentals.invoiceItems.delete');

    Route::resource('rentals.houses.tenants', TenantController::class)->parameters([
        'rentals' => 'rentalUuid',
        'houses' => 'houseUuid',
        'tenants' => 'tenantUuid',
    ]);

    Route::resource('rentals.houses.tenants.invoices', InvoiceController::class)->parameters([
        'rentals' => 'rentalUuid',
        'houses' => 'houseUuid',
        'tenants' => 'tenantUuid',
        'invoices' => 'invoiceUuid',
    ]);

    Route::resource('rentals.houses.tenants.invoices.payments', PaymentController::class)->parameters([
        'rentals' => 'rentalUuid',
        'houses' => 'houseUuid',
        'tenants' => 'tenantUuid',
        'invoices' => 'invoiceUuid',
        'payments' => 'paymentUuid',
    ])->only('create', 'store');
});
