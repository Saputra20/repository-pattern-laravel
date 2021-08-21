<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

use App\Models\User;

Route::group(["namespace" => "API", "prefix" => "v1"], function () {
    Route::group(["namespace" => "Auth"], function () {
        Route::post("login", ["uses" => "LoginController@authenticate"]);
        Route::post("resend-otp", ["uses" => "LoginController@resendOtp"]);
        Route::post("verify-otp", ["uses" => "LoginController@verifyOtp"])->middleware(['auth.otp']);
        Route::post("resend-verification", ["uses" => "AccountController@sendActivateEmail"]);
        Route::post("register", ["uses" => "RegisterController@account"]);

        Route::group(['middleware' => 'auth.jwt'], function () {
            Route::get("account", ["uses" => "AccountController@account"]);
            Route::get("profile", ["uses" => "AccountController@profile"]);
            Route::get("business", ["uses" => "AccountController@business"]);
            Route::post("biodata", ["uses" => "RegisterController@biodata"]);
            Route::post("business", ["uses" => "RegisterController@business"]);
        });
    });

    Route::get('/list-va', 'PaymentController@getListVa');
    Route::get('/va/{id}', 'PaymentController@getVa');
    Route::post('/create-va', 'PaymentController@storeVa');
    Route::post('/notification-va/{type}', 'PaymentController@notificationVa');
    Route::post('/notification/{paymentMethod}/{type}' , 'PaymentController@notification');
    Route::get('/notification-midtrans' , 'PaymentController@notificationMidtrans');
    Route::get('/snap-midtrans' , 'PaymentController@snapMidtrans');

    Route::get('/users' , 'UserController@index');

    Route::group(['middleware' => 'auth.jwt'], function () {
        Route::get("/test", function () {
            $user = User::all();
            return ApiResponse::success("success", $user);
        });
    });
});
