<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\DailyOfferController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\PartyQuotationController;

use App\Http\Controllers\Cashier\POSController;
use App\Http\Controllers\Kitchen\KitchenController;
use App\Http\Controllers\Delivery\DeliveryController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\CategoryController;

use App\Http\Controllers\Admin\HeroController;


Route::get('/', function () {
    return redirect('/login');
});



/*
|--------------------------------------------------------------------------
| DEFAULT DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return redirect('/admin/dashboard');
})->middleware(['auth'])->name('dashboard');



/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});



/*
|--------------------------------------------------------------------------
| ADMIN + MANAGER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager'])->group(function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::resource('/admin/categories', CategoryController::class);

    Route::resource('/admin/menu-items', MenuItemController::class);
    Route::post('/admin/menu-items/{id}/add-stock', [MenuItemController::class, 'addStock'])->name('menu-items.add-stock');

    Route::resource('/admin/orders', OrderController::class);

    Route::resource('/admin/daily-offers', DailyOfferController::class);

    Route::resource('/admin/coupons', CouponController::class);

    Route::resource('/admin/party-quotations', PartyQuotationController::class);

    Route::resource('/admin/reports', ReportController::class);

     Route::resource('/admin/heroes', HeroController::class);

     Route::resource('/admin/branches', BranchController::class);
});



/*
|--------------------------------------------------------------------------
| CASHIER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:cashier,admin'])->prefix('cashier')->group(function () {

    Route::get('/dashboard', [POSController::class, 'index'])->name('cashier.dashboard');
     // Status update via PUT (Secure)
    Route::post('/pos/orders', [POSController::class, 'store'])->name('pos.orders.store');
});


/*
|--------------------------------------------------------------------------
| KITCHEN
|--------------------------------------------------------------------------
*/


Route::middleware(['auth', 'role:kitchen,admin'])->prefix('kitchen')->group(function () {
    // Dashboard index
    Route::get('/dashboard', [KitchenController::class, 'index'])->name('kitchen.index');

    // Status update via PUT (Secure)
    Route::put('/orders/{order}/{status}', [KitchenController::class, 'updateStatus'])->name('kitchen.update');
});



/*
|--------------------------------------------------------------------------
| DELIVERY
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:delivery,admin'])->prefix('delivery')->group(function () {

    Route::get('/dashboard', [DeliveryController::class, 'index'])
        ->name('delivery.dashboard');
	// 3. Mark as delivered (using the method you created in the controller)
    //Route::put('/orders/{id}/delivered', [DeliveryController::class, 'updateStatus'])->name('delivery.updateStatus');
    Route::put('/orders/{order}/{status}', [DeliveryController::class, 'updateStatus'])->name('delivery.updateStatus');

   // Route::put('/orders/{order}/{status}', [DeliveryController::class, 'updateStatus'])->name('delivery.update');
});





/*
|--------------------------------------------------------------------------
| DELIVERY
|--------------------------------------------------------------------------
*/




require __DIR__.'/auth.php';
