<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1', 'namespace' => '\App\Http\Controllers\Api'], function () {
    Route::post("/login", "AuthController@login");
    Route::get("/users", "UsersController@users");
    Route::get("/logout", "AuthController@logout");
    Route::post("/register", "AuthController@register");
    Route::post("report/register", "ReportsController@register");

    Route::get("/getPlaces", "PlacesController@getPlaces");
    Route::get("/getIncidents", "IncidentsController@getIncidents");
});
