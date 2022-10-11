<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminController as AdminController;
use App\Http\Controllers\Admin\Front\SettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\Media\ImageController as AdminImageController;
use App\Http\Controllers\Admin\PageController as AdminPageController;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgetController;
use App\Http\Controllers\Auth\VerifyController;
use App\Http\Controllers\Front\FrontController;

// ADMIN
Route::group([
    "prefix" => "admin",
    "middleware" => ["auth", "admin_access", "throttle:admin_visitor_limits"]
], function () {
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

    Route::group(["prefix" => "medias"], function () {
        Route::get("/images", [AdminImageController::class, "index"])->name("admin.medias.images.index");
        Route::get("/images/show/{image}", [AdminImageController::class, "show"])->name("admin.medias.images.show");
        Route::get("/images/create", [AdminImageController::class, "create"])->name("admin.medias.images.create");
        Route::post("/images/store", [AdminImageController::class, "store"])->name("admin.medias.images.store");
        Route::post("/images/upload", [AdminImageController::class, "upload"])->name("admin.medias.images.upload");
        Route::get("/images/update/{image}", [AdminImageController::class, "edit"])->name("admin.medias.images.edit");
        Route::post("/images/update/{image}", [AdminImageController::class, "update"])->name("admin.medias.images.update");
        Route::post("/images/delete/{image}", [AdminImageController::class, "destroy"])->name("admin.medias.images.destroy");
    });

    Route::get("/pages", [AdminPageController::class, "index"])->name("admin.pages.index");
    Route::get("/pages/create", [AdminPageController::class, "create"])->name("admin.pages.create");
    Route::post("/pages/store", [AdminPageController::class, "store"])->name("admin.pages.store");
    Route::get("/pages/edit/{page}", [AdminPageController::class, "edit"])->name("admin.pages.edit");
    Route::post("/pages/update/{page}", [AdminPageController::class, "update"])->name("admin.pages.update");
    Route::post("/pages/destroy/{page}", [AdminPageController::class, "destroy"])->name("admin.pages.destroy");

    // FRONT SETTINGS
    Route::get("/settings", [SettingController::class, "edit"])->name("admin.settings.edit");
    Route::post("/settings", [SettingController::class, "update"])->name("admin.settings.update");
});

// FRONT/SITE
Route::group([], function () {
    Route::get('/', [FrontController::class, "index"])->name("front.index");

    Route::get('/mailable', function () {
        // 
    })->name("front.mailable");

    Route::get("/builder", [\App\Http\Controllers\Builder::class, "build"]);
});

// AUTH
Route::group(["prefix" => "auth"], function () {
    Route::group(["middleware" => ["guest"]], function () {
        Route::get("/login", [AuthController::class, "login"])->name("auth.login");
        Route::post("/login", [AuthController::class, "authenticate"])->name("auth.authenticate")->middleware("throttle:auth_attempts");
        Route::get("/register", [AuthController::class, "register"])->name("auth.register");
        Route::post("/register", [AuthController::class, "store"])->name("auth.store");

        Route::get("/forget-password", [ForgetController::class, "forget"])->name("auth.forget");
        Route::post("/forget-password", [ForgetController::class, "sendRecoveryLink"])->name("auth.sendRecoveryLink")->middleware("throttle:auth_attempts");
        Route::get("/reset-password/{token}", [ForgetController::class, "reset"])->name("auth.reset");
        Route::post("/reset-password", [ForgetController::class, "resetPassword"])->name("auth.resetPassword");
    });

    Route::group(["middleware" => ["auth"]], function () {
        Route::get("/logout", [AuthController::class, "logout"])->name("auth.logout");

        Route::get("/notify", [VerifyController::class, "notify"])->name("auth.notify");
        Route::get("/verify-register/{token}", [VerifyController::class, "verify"])->name("auth.verify");
        Route::post("/verify-register", [VerifyController::class, "verifyRegister"])->name("auth.verifyRegister");
        Route::post("/verification-resend", [VerifyController::class, "verificationResend"])->name("auth.verificationResend");
    });
});
