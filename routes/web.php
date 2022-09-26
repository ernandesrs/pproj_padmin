<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
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

Route::get('/', function () {
    return redirect("/admin");
})->name("front.index");

Route::group(["prefix" => "auth"], function () {
    Route::get("/login", [AuthController::class, "login"])->name("auth.login");
    Route::post("/login", [AuthController::class, "authenticate"])->name("auth.authenticate");
    Route::get("/register", [AuthController::class, "register"])->name("auth.register");
    Route::post("/register", [AuthController::class, "store"])->name("auth.store");
});

Route::group(["prefix" => "admin"], function () {
    Route::get("/", [AdminController::class, "index"])->name("admin.index");
});
