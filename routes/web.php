<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ExampleController as AdminExampleController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
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
    return "front: :D";
})->name("front.index");

Route::group(["prefix" => "auth"], function () {
    Route::group(["middleware" => ["guest"]], function () {
        Route::get("/login", [AuthController::class, "login"])->name("auth.login");
        Route::post("/login", [AuthController::class, "authenticate"])->name("auth.authenticate");
        Route::get("/register", [AuthController::class, "register"])->name("auth.register");
        Route::post("/register", [AuthController::class, "store"])->name("auth.store");
    });

    Route::group(["middleware" => ["auth"]], function () {
        Route::get("/logout", [AuthController::class, "logout"])->name("auth.logout");
    });
});

Route::group(["prefix" => "admin", "middleware" => ["auth", "admin_access"]], function () {
    Route::get("/", [AdminController::class, "index"])->name("admin.index");

    Route::group(["prefix" => "users"], function () {
        Route::get("/", [AdminUserController::class, "index"])->name("admin.users.index");
        Route::get("/create", [AdminUserController::class, "create"])->name("admin.users.create");
        Route::post("/create", [AdminUserController::class, "store"])->name("admin.users.store");
        Route::get("/edit/{user}", [AdminUserController::class, "edit"])->name("admin.users.edit");
        Route::post("/edit/{user}", [AdminUserController::class, "update"])->name("admin.users.update");
        Route::post("/destroy/{user}", [AdminUserController::class, "destroy"])->name("admin.users.destroy");
        Route::post("/promote/{user}", [AdminUserController::class, "promote"])->name("admin.users.promote");
        Route::post("/demote/{user}", [AdminUserController::class, "demote"])->name("admin.users.demote");
    });

    Route::group(["prefix" => "example"], function () {
        Route::get("/", [AdminExampleController::class, "example1"])->name("admin.example1");
        Route::get("/example2", [AdminExampleController::class, "example2"])->name("admin.example2");
        Route::get("/example3", [AdminExampleController::class, "example3"])->name("admin.example3");
        Route::get("/example4", [AdminExampleController::class, "example4"])->name("admin.example4");
    });
});
