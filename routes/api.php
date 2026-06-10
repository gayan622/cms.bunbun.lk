<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\PartyQuotationController;
use App\Http\Controllers\Api\HeroController;
use App\Http\Controllers\Api\CategoryController;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
/*
|--------------------------------------------------------------------------
| Public Token Login
|--------------------------------------------------------------------------
*/
Route::post('/login-token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $admin = Admin::where('email', $request->email)->first();

    if (! $admin || ! Hash::check($request->password, $admin->password)) {
        return response()->json([
            'message' => 'Unauthorized',
        ], 401);
    }

    $token = $admin
        ->createToken('admin-token')
        ->plainTextToken;

    return response()->json([
        'token' => $token,
    ]);
});

Route::options('{any}', function () {
    return response()->json([], 200);
})->where('any', '.*');

/*
|--------------------------------------------------------------------------
| PUBLIC API
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);

Route::get('/categories', [CategoryController::class, 'index']);

Route::get('/menu', [MenuController::class, 'index']);

Route::get('/offers/today', [OfferController::class, 'today']);

Route::post('/party-quotations', [
    PartyQuotationController::class,
    'store'
]);


Route::get('/branches', [MenuController::class, 'branches']);
Route::get('/branches/{branch}/menu', [MenuController::class, 'branchMenu']);

/*
|--------------------------------------------------------------------------
| PROTECTED API
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/profile', [AuthController::class, 'profile']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/orders', [OrderController::class, 'store']);

    Route::post('/coupons/validate', [
        CouponController::class,
        'validateCoupon'
    ]);

});


/*
|--------------------------------------------------------------------------
| PROTECTED API
|--------------------------------------------------------------------------
*/
Route::get('/hero', [HeroController::class, 'index']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/admin/heroes', [HeroController::class, 'all']);
    Route::post('/admin/heroes', [HeroController::class, 'store']);
    Route::put('/admin/heroes/{id}', [HeroController::class, 'update']);
    Route::delete('/admin/heroes/{id}', [HeroController::class, 'destroy']);
    Route::post('/admin/heroes/{id}/active', [HeroController::class, 'setActive']);
});



