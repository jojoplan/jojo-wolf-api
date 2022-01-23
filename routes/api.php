<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WolfController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PackController;

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

//Route::middleware('auth:sanctum')->get('/wolf/{name}', function (Request $request, $name) {
// Route::get('/wolves/{name}', function (Request $request, $name) {
//     return response('{"name": "' . $name . '"}', 200)
//                   ->header('Content-Type', 'application/json');
// })->where('name', '[A-Za-z]+');

Route::get('/wolves/locations', [WolfController::class, 'locations']);
Route::post('/packs/{pack}/wolves', [WolfController::class, 'addToPack']);
Route::apiResources([
	'wolves' => WolfController::class,
	'wolves.location' => LocationController::class,
	'packs' => PackController::class
]);
