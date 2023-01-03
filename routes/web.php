<?php

use App\Http\Controllers\Admin\AdminController as AdminController;
use App\Http\Controllers\Admin\Front\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\Front\SectionController as AdminSectionController;
use App\Http\Controllers\Admin\Front\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\Front\SettingController;
use App\Http\Controllers\Admin\Media\ImageController as AdminImageController;
use App\Http\Controllers\Admin\Media\VideoController as AdminVideoController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgetController;
use App\Http\Controllers\Auth\VerifyController;
use App\Http\Controllers\Front\FrontController;
use Illuminate\Support\Facades\Route;

// ADMIN
Route::group([
    "prefix" => "admin",
    "middleware" => ["auth", "admin_access"],
], function () {
    Route::get("/", [AdminController::class, "index"])->name("admin.index");

    Route::resource("users", AdminUserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
    Route::post("/users/{user}/upload-photo", [AdminUserController::class, "uploadPhoto"])->name("admin.users.uploadPhoto");

    Route::resource("roles", AdminRoleController::class)->names([
        'index' => 'admin.roles.index',
        'create' => 'admin.roles.create',
        'store' => 'admin.roles.store',
        'edit' => 'admin.roles.edit',
        'update' => 'admin.roles.update',
        'destroy' => 'admin.roles.destroy',
    ]);

    Route::group(["prefix" => "medias"], function () {
        Route::resource("images", AdminImageController::class)->names([
            'index' => 'admin.medias.images.index',
            'show' => 'admin.medias.images.show',
            'create' => 'admin.medias.images.create',
            'store' => 'admin.medias.images.store',
            'edit' => 'admin.medias.images.edit',
            'update' => 'admin.medias.images.update',
            'destroy' => 'admin.medias.images.destroy',
        ]);
        Route::post("/images/upload", [AdminImageController::class, "upload"])->name("admin.medias.images.upload");

        Route::resource("videos", AdminVideoController::class)->names([
            'index' => 'admin.medias.videos.index',
            'show' => 'admin.medias.videos.show',
            'create' => 'admin.medias.videos.create',
            'store' => 'admin.medias.videos.store',
            'edit' => 'admin.medias.videos.edit',
            'update' => 'admin.medias.videos.update',
            'destroy' => 'admin.medias.videos.destroy',
        ]);
        Route::post("/videos/upload", [AdminImageController::class, "upload"])->name("admin.medias.videos.upload");
    });

    Route::resource("pages", AdminPageController::class)->names([
        'index' => 'admin.pages.index',
        'create' => 'admin.pages.create',
        'store' => 'admin.pages.store',
        'edit' => 'admin.pages.edit',
        'update' => 'admin.pages.update',
        'destroy' => 'admin.pages.destroy',
    ]);
    Route::resource("services", AdminServiceController::class)->names([
        'index' => 'admin.services.index',
        'create' => 'admin.services.create',
        'store' => 'admin.services.store',
        'edit' => 'admin.services.edit',
        'update' => 'admin.services.update',
        'destroy' => 'admin.services.destroy',
    ]);

    Route::resource("sections", AdminSectionController::class)->names([
        'index' => 'admin.sections.index',
        'create' => 'admin.sections.create',
        'store' => 'admin.sections.store',
        'edit' => 'admin.sections.edit',
        'update' => 'admin.sections.update',
        'destroy' => 'admin.sections.destroy',
    ]);

    Route::resource("menus", AdminMenuController::class)->names([
        'index' => 'admin.menus.index',
        'create' => 'admin.menus.create',
        'store' => 'admin.menus.store',
        'edit' => 'admin.menus.edit',
        'update' => 'admin.menus.update',
        'destroy' => 'admin.menus.destroy',
    ]);

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
});

// AUTH
Route::group(["prefix" => "auth"], function () {
    Route::group(["middleware" => ["guest"]], function () {
        Route::get("/login", [AuthController::class, "login"])->name("auth.login");
        Route::post("/login", [AuthController::class, "authenticate"])->name("auth.authenticate")->middleware("throttle:auth_attempts");
        Route::get("/register", [AuthController::class, "register"])->name("auth.register");
        Route::post("/register", [AuthController::class, "store"])->name("auth.store");

        Route::get("/forget-password", [ForgetController::class, "forget"])->name("auth.forget");
        Route::post("/forget-password", [ForgetController::class, "sendRecoveryLink"])->name("auth.sendRecoveryLink");
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
