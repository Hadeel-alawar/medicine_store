<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\PharController;
use App\Http\Controllers\ReqController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(["prefix" => "pharmacist"], function () {
    Route::post("create", [PharController::class, "reg"]);
    Route::post("login", [PharController::class, "login"]);
    Route::post("logout", [PharController::class, "logout"]);
    Route::get("surf", [MedicationController::class, "browse"]);
    Route::post("search", [MedicationController::class, "search"]);
    Route::get("show/{id}", [MedicationController::class, "viewSpecifics"]);
    Route::post("addReq", [ReqController::class, "store"]);
});

Route::group(["prefix" => "admin"], function () {
    Route::post("add", [MedicationController::class, "addMedication"]);
});
