<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CountryStateCityController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

	Route::get('/countries', [CountryStateCityController::class, 'getCountries']);
	Route::get('/cities/{countryId}', [CountryStateCityController::class, 'getCities']);
	Route::get('/counties/{cityId}', [CountryStateCityController::class, 'getCounties']);
	Route::get('/districts/{countyId}', [CountryStateCityController::class, 'getDistricts']);
	Route::get('/neighborhoods/{districtId}', [CountryStateCityController::class, 'getNeighborhoods']);
